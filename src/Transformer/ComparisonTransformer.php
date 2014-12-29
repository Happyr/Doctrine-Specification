<?php

namespace Happyr\DoctrineSpecification\Transformer;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Filter\Base\Comparison;
use Happyr\DoctrineSpecification\Filter\Base\FilterInterface;
use Happyr\DoctrineSpecification\Filter\Equals;
use Happyr\DoctrineSpecification\Filter\GreaterOrEqualThan;
use Happyr\DoctrineSpecification\Filter\GreaterThan;
use Happyr\DoctrineSpecification\Filter\In;
use Happyr\DoctrineSpecification\Filter\LessOrEqualThan;
use Happyr\DoctrineSpecification\Filter\LessThan;
use Happyr\DoctrineSpecification\Filter\Like;
use Happyr\DoctrineSpecification\Filter\NotEquals;
use Happyr\DoctrineSpecification\ParametersBag;

class ComparisonTransformer implements FilterTransformerInterface
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
    public function supports(FilterInterface $object)
    {
        if ($object instanceof Comparison) {
            return $object instanceof Equals
                || $object instanceof NotEquals
                || $object instanceof GreaterOrEqualThan
                || $object instanceof GreaterThan
                || $object instanceof LessOrEqualThan
                || $object instanceof LessThan
                || $object instanceof In
                || $object instanceof Like;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function transform(FilterInterface $filter, ParametersBag $parameters)
    {
        if ($filter instanceof Equals) {
            return $this->transformEquals($filter, $parameters);
        } elseif ($filter instanceof NotEquals) {
            return $this->transformNotEquals($filter, $parameters);
        } elseif ($filter instanceof GreaterOrEqualThan) {
            return $this->transformGreaterThanOrEquals($filter, $parameters);
        } elseif ($filter instanceof GreaterThan) {
            return $this->trasformGreaterThan($filter, $parameters);
        } elseif ($filter instanceof LessOrEqualThan) {
            return $this->transformLessThanOrEquals($filter, $parameters);
        } elseif ($filter instanceof LessThan) {
            return $this->transformLessThan($filter, $parameters);
        } elseif ($filter instanceof In) {
            return $this->transformIn($filter, $parameters);
        } elseif ($filter instanceof Like) {
            return $this->transformLike($filter, $parameters);
        }

        throw new InvalidArgumentException("Comparison transformer does not support " . get_class($filter) . " class");
    }

    private function transformEquals(Equals $filter, ParametersBag $parameters)
    {
        $name = $parameters->add($filter->getValue());
        $expression = (string)($this->queryBuilder->expr()->eq($filter->getField(), $name));
        return (string)$expression;
    }

    private function transformNotEquals(NotEquals $filter, ParametersBag $parameters)
    {
        $name = $parameters->add($filter->getValue());
        $expression = (string)($this->queryBuilder->expr()->neq($filter->getField(), $name));

        return (string)$expression;
    }

    private function transformGreaterThanOrEquals(GreaterOrEqualThan $filter, ParametersBag $parameters)
    {
        $name = $parameters->add($filter->getValue());
        $expression = (string)($this->queryBuilder->expr()->gte($filter->getField(), $name));

        return (string)$expression;
    }

    private function trasformGreaterThan(GreaterThan $filter, ParametersBag $parameters)
    {
        $name = $parameters->add($filter->getValue());
        $expression = (string)($this->queryBuilder->expr()->gt($filter->getField(), $name));

        return (string)$expression;
    }

    private function transformLessThanOrEquals(LessOrEqualThan $filter, ParametersBag $parameters)
    {
        $name = $parameters->add($filter->getValue());
        $expression = (string)($this->queryBuilder->expr()->lte($filter->getField(), $name));

        return (string)$expression;
    }

    private function transformLessThan(LessThan $filter, ParametersBag $parameters)
    {
        $name = $parameters->add($filter->getValue());
        $expression = (string)($this->queryBuilder->expr()->lt($filter->getField(), $name));

        return (string)$expression;
    }

    private function transformIn(In $filter, ParametersBag $parameters)
    {
        $name = $parameters->add($filter->getValue());
        $expression = (string)($this->queryBuilder->expr()->in($filter->getField(), $name));

        return (string)$expression;
    }

    private function transformLike(Like $filter, ParametersBag $parameters)
    {
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
        $name = $parameters->add($value);
        $expression = (string)($this->queryBuilder->expr()->like($filter->getField(), $name));

        return (string)$expression;
    }
}
