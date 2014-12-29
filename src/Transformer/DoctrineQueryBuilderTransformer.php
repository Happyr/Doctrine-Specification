<?php

namespace Happyr\DoctrineSpecification\Transformer;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Filter\Base\Filter;
use Happyr\DoctrineSpecification\Filter\Equals;
use Happyr\DoctrineSpecification\Filter\GreaterOrEqualThan;
use Happyr\DoctrineSpecification\Filter\GreaterThan;
use Happyr\DoctrineSpecification\Filter\In;
use Happyr\DoctrineSpecification\Filter\IsNotNull;
use Happyr\DoctrineSpecification\Filter\LessOrEqualThan;
use Happyr\DoctrineSpecification\Filter\LessThan;
use Happyr\DoctrineSpecification\Filter\Like;
use Happyr\DoctrineSpecification\Filter\NotEquals;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Filter\IsNull;

class DoctrineQueryBuilderTransformer
{
    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @var QueryBuilder
     */
    private $cleanQueryBuilder;

    /**
     * @var array
     */
    private $parameters;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->cleanQueryBuilder = $queryBuilder;
    }

    public function getQueryBuilder(Specification $specification)
    {
        $this->queryBuilder = clone $this->cleanQueryBuilder;
        $this->parameters = [];
        $this->queryBuilder->add('where', $this->resolve($specification->getFilter()));
        if (count($this->parameters)) {
            $this->queryBuilder->setParameters($this->parameters);
        }

        return $this->queryBuilder;
    }

    /**
     * @param Filter $filter
     *
     * @return string
     */
    private function resolve(Filter $filter)
    {
        if ($filter instanceof Equals) {
            $parameterName = count($this->parameters) + 1;
            $expression = (string)($this->queryBuilder->expr()->eq($filter->getField(), '?' . $parameterName));
            $this->parameters[$parameterName] = $filter->getValue();

            return (string)$expression;
        } elseif ($filter instanceof GreaterOrEqualThan) {
            $parameterName = count($this->parameters) + 1;
            $expression = (string)($this->queryBuilder->expr()->gte($filter->getField(), '?' . $parameterName));
            $this->parameters[$parameterName] = $filter->getValue();

            return (string)$expression;
        } elseif ($filter instanceof GreaterThan) {
            $parameterName = count($this->parameters) + 1;
            $expression = (string)($this->queryBuilder->expr()->gt($filter->getField(), '?' . $parameterName));
            $this->parameters[$parameterName] = $filter->getValue();

            return (string)$expression;
        } elseif ($filter instanceof In) {
            $parameterName = count($this->parameters) + 1;
            $expression = (string)($this->queryBuilder->expr()->in($filter->getField(), '?' . $parameterName));
            $this->parameters[$parameterName] = $filter->getValue();

            return (string)$expression;
        } elseif ($filter instanceof IsNotNull) {
            return (string)($this->queryBuilder->expr()->isNotNull($filter->getField()));
        } elseif ($filter instanceof IsNull) {
            return (string)($this->queryBuilder->expr()->isNull($filter->getField()));
        } elseif ($filter instanceof LessOrEqualThan) {
            $parameterName = count($this->parameters) + 1;
            $expression = (string)($this->queryBuilder->expr()->lte($filter->getField(), '?' . $parameterName));
            $this->parameters[$parameterName] = $filter->getValue();

            return (string)$expression;
        } elseif ($filter instanceof LessThan) {
            $parameterName = count($this->parameters) + 1;
            $expression = (string)($this->queryBuilder->expr()->lt($filter->getField(), '?' . $parameterName));
            $this->parameters[$parameterName] = $filter->getValue();

            return (string)$expression;
        } elseif ($filter instanceof NotEquals) {
            $parameterName = count($this->parameters) + 1;
            $expression = (string)($this->queryBuilder->expr()->neq($filter->getField(), '?' . $parameterName));
            $this->parameters[$parameterName] = $filter->getValue();

            return (string)$expression;
        } elseif ($filter instanceof Like) {
            $parameterName = count($this->parameters) + 1;
            $expression = (string)($this->queryBuilder->expr()->like($filter->getField(), '?' . $parameterName));
            /** @var $filter Like */
            $format = $filter->getFormat();
            $value = null;
            if (Like::CONTAINS === $format) {
                $value = "%" . $filter->getValue() . "%";
            } elseif (Like::STARTS_WITH === $format) {
                $value = "%" . $filter->getValue();
            } elseif (Like::ENDS_WITH === $format) {
                $value = $filter->getValue() . "%";
            } else {
                throw new InvalidArgumentException(sprintf("Unsupported filter like format %s.", $format));
            }
            $this->parameters[$parameterName] = $value;

            return (string)$expression;
        }
        throw new InvalidArgumentException(sprintf("Unsupported filter %s", get_class($filter)));
    }
}
