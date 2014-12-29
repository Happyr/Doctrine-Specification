<?php

namespace Happyr\DoctrineSpecification\Transformer;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Filter\Base\FilterInterface;
use Happyr\DoctrineSpecification\Filter\IsNotNull;
use Happyr\DoctrineSpecification\Filter\IsNull;
use Happyr\DoctrineSpecification\ParametersBag;

class FilterTransformer implements FilterTransformerInterface
{
    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @inheritdoc
     */
    public function setQueryBuilder(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @inheritdoc
     */
    public function supports(FilterInterface $filter)
    {
        return $filter instanceof IsNotNull || $filter instanceof IsNull;
    }

    /**
     * @inheritdoc
     */
    public function transform(FilterInterface $filter, ParametersBag $parameters)
    {
        if ($filter instanceof IsNull) {
            return $this->transformIsNull($filter);
        } elseif ($filter instanceof IsNotNull) {
            return $this->transformIsNotNull($filter);
        }

        throw new InvalidArgumentException("Filter transformer does not support " . get_class($filter) . " class");
    }

    private function transformIsNull($filter)
    {
        return (string)($this->queryBuilder->expr()->isNull($filter->getField()));
    }

    private function transformIsNotNull($filter)
    {
        return (string)($this->queryBuilder->expr()->isNotNull($filter->getField()));
    }
}
