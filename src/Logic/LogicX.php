<?php

namespace Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Specification;

/**
 * This class should be used when you combine two or more Expressions
 */
class LogicX
{
    const AND_X = 'andX';
    const OR_X = 'orX';

    /**
     * @var Filter[] children
     */
    private $children;

    /**
     * @var string
     */
    private $expression;

    /**
     * Take two or more Expression as parameters
     *
     * @param string $expression
     * @param Filter[] $children
     */
    public function __construct($expression, array $children)
    {
        $this->expression = $expression;
        $this->children = $children;
    }

    /**
     * @param QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, $dqlAlias)
    {
        return call_user_func_array(
            array($qb->expr(), $this->expression),
            array_map(
                function (Filter $expr) use ($qb, $dqlAlias) {
                    return $expr->getFilter($qb, $dqlAlias);
                },
                $this->children
            )
        );
    }

    /**
     * @param QueryBuilder $query
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $query, $dqlAlias)
    {
        foreach ($this->children as $child) {
            if ($child instanceof Specification) {
                $child->modify($query, $dqlAlias);
            }
        }
    }
}
