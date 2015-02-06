<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Filter\Base\FilterInterface;
use Happyr\DoctrineSpecification\Filter\Equals;
use Happyr\DoctrineSpecification\Filter\GreaterOrEqualThan;
use Happyr\DoctrineSpecification\Filter\GreaterThan;
use Happyr\DoctrineSpecification\Filter\In;
use Happyr\DoctrineSpecification\Filter\IsNotNull;
use Happyr\DoctrineSpecification\Filter\IsNull;
use Happyr\DoctrineSpecification\Filter\LessOrEqualThan;
use Happyr\DoctrineSpecification\Filter\LessThan;
use Happyr\DoctrineSpecification\Filter\Like;
use Happyr\DoctrineSpecification\Filter\NotEquals;
use Happyr\DoctrineSpecification\Logic\AndX;
use Happyr\DoctrineSpecification\Logic\Not;
use Happyr\DoctrineSpecification\Logic\OrX;

class DoctrineTransformer
{
    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
        $this->expression = $this->queryBuilder->expr();
    }

    /**
     * Modify query builder according to specification
     *
     * @param FilterInterface $specification
     * @return QueryBuilder modified query builder
     */
    public function getQueryBuilder(FilterInterface $specification)
    {
        $parameters = new ParametersBag();
        $queryBuilder = clone $this->queryBuilder;

        $result = $this->getDQLPart($specification->getFilter(), $parameters);
        $queryBuilder->add('where', $result);

        return $queryBuilder;
    }

    /**
     * Transform specification to DQL part
     *
     * @param FilterInterface $specification
     * @param ParametersBag $parameters
     * @return QueryBuilder modified query builder
     */
    public function getDQLPart(FilterInterface $specification, ParametersBag $parameters)
    {
        return $this->getFilterDqlPart($specification, $parameters);
    }

    private function getFilterDqlPart(FilterInterface $specification, ParametersBag $parameters)
    {
        switch (get_class($specification)) {
            case 'Happyr\DoctrineSpecification\Filter\Equals':

                return $this->getDqlFromEquals($specification, $parameters);
            case 'Happyr\DoctrineSpecification\Filter\GreaterOrEqualThan':

                return $this->getDqlFromGreaterOrEqualThan($specification, $parameters);
            case 'Happyr\DoctrineSpecification\Filter\GreaterThan':

                return $this->getDqlFromGreaterThan($specification, $parameters);
            case 'Happyr\DoctrineSpecification\Filter\In':

                return $this->getDqlFromIn($specification, $parameters);
            case 'Happyr\DoctrineSpecification\Filter\IsNotNull':

                return $this->getDqlFromIsNotNull($specification, $parameters);
            case 'Happyr\DoctrineSpecification\Filter\IsNull':

                return $this->getDqlFromIsNull($specification, $parameters);
            case 'Happyr\DoctrineSpecification\Filter\LessOrEqualThan':
                return $this->getDqlFromLessOrEqualThan($specification, $parameters);

            case 'Happyr\DoctrineSpecification\Filter\LessThan':

                return $this->getDqlFromLessThan($specification, $parameters);
            case 'Happyr\DoctrineSpecification\Filter\Like':

                return $this->getDqlFromLike($specification, $parameters);
            case 'Happyr\DoctrineSpecification\Filter\NotEquals':

                return $this->getDqlFromNotEquals($specification, $parameters);
            case 'Happyr\DoctrineSpecification\Logic\AndX':

                return $this->getDqlFromAndX($specification, $parameters);
            case 'Happyr\DoctrineSpecification\Logic\Not':

                return $this->getDqlFromNot($specification, $parameters);
            case 'Happyr\DoctrineSpecification\Logic\OrX':

                return $this->getDqlFromOrX($specification, $parameters);
            default:
                throw new InvalidArgumentException(sprintf("Specification %s is not supported", get_class($specification)));
        }
    }

    private function getDqlFromIsNotNull(IsNotNull $filter)
    {
        return (string)($this->expression->isNotNull($filter->getField()));
    }

    private function getDqlFromIsNull(IsNull $filter)
    {
        return (string)($this->expression->isNull($filter->getField()));
    }

    private function getDqlFromEquals(Equals $filter, ParametersBag $parameters)
    {
        $parameters->add($filter->getValue());

        return (string)($this->expression->eq($filter->getField(), $parameters->getLastName()));
    }

    private function getDqlFromGreaterOrEqualThan(GreaterOrEqualThan $filter, ParametersBag $parameters)
    {
        $parameters->add($filter->getValue());

        return (string)($this->expression->gte($filter->getField(), $parameters->getLastName()));
    }

    private function getDqlFromNotEquals(NotEquals $filter, ParametersBag $parameters)
    {
        $parameters->add($filter->getValue());

        return (string)($this->expression->neq($filter->getField(), $parameters->getLastName()));
    }

    private function getDqlFromGreaterThan(GreaterThan $filter, ParametersBag $parameters)
    {
        $parameters->add($filter->getValue());

        return (string)($this->expression->gt($filter->getField(), $parameters->getLastName()));
    }

    private function getDqlFromLessOrEqualThan(LessOrEqualThan $filter, ParametersBag $parameters)
    {
        $parameters->add($filter->getValue());

        return (string)($this->expression->lte($filter->getField(), $parameters->getLastName()));
    }

    private function getDqlFromLessThan(LessThan $filter, ParametersBag $parameters)
    {
        $parameters->add($filter->getValue());

        return (string)($this->expression->lt($filter->getField(), $parameters->getLastName()));
    }

    private function getDqlFromIn(In $filter, ParametersBag $parameters)
    {
        $parameters->add($filter->getValue());

        return (string)($this->expression->in($filter->getField(), $parameters->getLastName()));
    }

    private function getDqlFromLike(Like $filter, ParametersBag $parameters)
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
        $parameters->add($value);

        return (string)($this->expression->like($filter->getField(), $parameters->getLastName()));
    }

    private function getDqlFromNot(Not $logic, ParametersBag $parameters)
    {
        $restriction = $this->getDQLPart($logic->getExpression(), $parameters);
        return $this->expression->not($restriction);
    }

    private function getDqlFromAndX(AndX $logic, ParametersBag $parameters)
    {
        $left = $this->getDQLPart($logic->getLeft(), $parameters);
        $right = $this->getDQLPart($logic->getRight(), $parameters);

        return $this->expression->andX($left, $right);
    }

    private function getDqlFromOrX(OrX $logic, ParametersBag $parameters)
    {
        $left = $this->getDQLPart($logic->getLeft(), $parameters);
        $right = $this->getDQLPart($logic->getRight(), $parameters);

        return $this->expression->orX($left, $right);
    }
}
