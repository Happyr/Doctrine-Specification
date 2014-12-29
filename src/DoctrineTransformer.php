<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Transformer\FilterTransformerInterface;

class DoctrineTransformer
{
    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @var ParametersBag
     */
    private $parameters;

    /**
     * @var FilterTransformerInterface[]
     */
    private $transformers = [];

    public function __construct(ParametersBag $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @param QueryBuilder $queryBuilder
     */
    public function setQueryBuilder($queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * Modify query builder according to specification
     *
     * @param Specification $specification
     * @return QueryBuilder modified query builder
     */
    public function transform(Specification $specification)
    {
        $queryBuilder = clone $this->queryBuilder;
        return $this->addWhere($specification, $queryBuilder);
    }

    private function getTransformers()
    {
        return $this->transformers;
    }

    /**
     * Add transformer to collection to use to transform specifications
     * @param FilterTransformerInterface $transformer
     */
    public function addTransformer(FilterTransformerInterface $transformer)
    {
        $this->transformers[] = $transformer;
    }

    /**
     * Build where part
     * @param Specification $specification
     * @param $queryBuilder
     *
     * @return QueryBuilder
     */
    private function addWhere(Specification $specification, $queryBuilder)
    {
        $this->parameters->clear();

        foreach ($this->getTransformers() as $transformer) {
            /** @var $transformer FilterTransformerInterface */
            if ($transformer->supports($specification->getFilter())) {
                $result = $transformer->transform($specification->getFilter(), $this->parameters, $queryBuilder);
                $this->queryBuilder->add('where', $result);

                if ($this->parameters->has()) {
                    $this->queryBuilder->setParameters($this->parameters->get());
                }

                return $this->queryBuilder;
            }
        }
        throw new InvalidArgumentException('Doctrine Transformer does not support ' . get_class($specification->getFilter()) . ' class');
    }
}
