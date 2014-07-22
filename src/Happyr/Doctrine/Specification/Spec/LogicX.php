<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

/**
 * Abstract Class LogicX
 *
 * This class should be used when you combine two specifications
 *
 * @author Tobias Nyholm
 * @author Benjamin Eberlei
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
     * @return Expr|mixed
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        return call_user_func_array(
            array($qb->expr(), $this->expression),
            array_map(
                function (Specification $spec) use ($qb, $dqlAlias) {
                    return $spec->match($qb, $dqlAlias);
                },
                $this->children
            )
        );
    }

    /**
     * @param AbstractQuery $query
     */
    public function modifyQuery(AbstractQuery $query)
    {
        foreach ($this->children as $child) {
            $child->modifyQuery($query);
        }
    }

    /**
     * @param string $className
     *
     * @return bool
     */
    public function supports($className)
    {
        return true;
    }
}
