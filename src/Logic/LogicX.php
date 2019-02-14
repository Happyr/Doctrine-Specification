<?php

namespace Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Specification\Specification;

/**
 * This class should be used when you combine two or more Expressions.
 */
class LogicX implements Specification
{
    const AND_X = 'andX';

    const OR_X = 'orX';

    /**
     * @var Filter[]|QueryModifier[] children
     */
    private $children;

    /**
     * @var string
     */
    private $expression;

    /**
     * Take two or more Expression as parameters.
     *
     * @param string                   $expression
     * @param Filter[]|QueryModifier[] $children
     */
    public function __construct($expression, array $children = array())
    {
        $this->expression = $expression;
        $this->children = $children;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, $dqlAlias)
    {
        return call_user_func_array(
            array($qb->expr(), $this->expression),
            array_map(
                function ($spec) use ($qb, $dqlAlias) {
                    if ($spec instanceof Filter) {
                        return $spec->getFilter($qb, $dqlAlias);
                    }
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
            if ($child instanceof QueryModifier) {
                $child->modify($query, $dqlAlias);
            }
        }
    }

    /**
     * Add another child to this logic tree.
     *
     * @param |Happyr\DoctrineSpecification\Filter\Filter|\Happyr\DoctrineSpecification\Query\QueryModifier $child
     */
    protected function append($child)
    {
        $this->children[] = $child;
    }
}
