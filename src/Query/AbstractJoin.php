<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Join as DoctrineJoin;

use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;

/**
 * @author Tobias Nyholm
 */
abstract class AbstractJoin implements QueryModifier
{
    /**
     * @var string field
     */
    private $field;

    /**
     * @var string alias
     */
    private $newAlias;

    /**
     * @var string dqlAlias
     */
    private $dqlAlias;

    /**
     * @var Filter|string|array
     */
    private $condition;

    /**
     * @var string
     */
    private $conditionType;

    /**
     * @param string $field
     * @param string $newAlias
     * @param string $dqlAlias
     * @param Filter|array|string $condition
     * @param string $conditionType
     */
    public function __construct($field, $newAlias, $dqlAlias = null, $condition = null, $conditionType = null)
    {
        $this->field = $field;
        $this->newAlias = $newAlias;
        $this->dqlAlias = $dqlAlias;
        $this->condition = $condition;
        $this->conditionType = $conditionType;
    }

    /**
     * Return a join type (ie a function of QueryBuilder) like: "join", "innerJoin", "leftJoin".
     *
     * @return string
     */
    abstract protected function getJoinType();

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        $join = $this->getJoinType();

        $qb->$join(
            sprintf('%s.%s', $dqlAlias, $this->field),
            $this->newAlias,
            $this->getJoinConditionType(),
            $this->getJoinCondition($this->condition, $qb)
        );
    }

    private function getJoinCondition($condition, $qb)
    {
        if ($condition instanceof Filter) {
            return $condition->getFilter($qb, $this->newAlias);
        } elseif (is_string($condition)) {
            return $condition;
        } elseif (is_array($condition)) {
            return call_user_func_array(
                [$qb->expr(), 'andX'],
                array_map(function($cond) use($qb) {
                    return $this->getJoinCondition($cond, $qb);
                }, $condition)
            );
        }
    }

    private function getJoinConditionType()
    {
        if (!$this->condition) {
            return;
        }
        if (!$this->conditionType) {
            return DoctrineJoin::WITH;
        }
        if (!in_array($this->conditionType, [DoctrineJoin::ON, DoctrineJoin::WITH])) {
            throw new InvalidArgumentException(
                'Join condition type must be \Doctrine\ORM\Query\Expr\Join::ON or \Doctrine\ORM\Query\Expr\Join::WITH'
            );
        }
        return $this->conditionType;
    }
    
}
