<?php

namespace Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Specification;

/**
 * Abstract Class LogicX
 *
 * This class should be used when you combine two or more specifications
 */
class LogicX implements Specification
{
    const AND_X = 'andX';
    const OR_X = 'orX';

    /**
     * @var Specification[] children
     */
    private $children;

    /**
     * @var string
     */
    private $expression;

    /**
     * Take two or more Specification as parameters
     *
     * @param string $expression
     * @param array  $children
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
    public function getExpression(QueryBuilder $qb, $dqlAlias)
    {
        return call_user_func_array(
            array($qb->expr(), $this->expression),
            array_map(
                function (Specification $spec) use ($qb, $dqlAlias) {
                    return $spec->getExpression($qb, $dqlAlias);
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
            $child->modify($query, $dqlAlias);
        }
    }
}
