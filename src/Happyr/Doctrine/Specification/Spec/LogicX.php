<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Abstract Class LogicX
 *
 * This class should be used when you combine two specifications
 *
 * @author Tobias Nyholm
 * @author Benjamin Eberlei
 */
abstract class LogicX implements Specification
{
    /**
     * @var Specification[] children
     *
     */
    private $children;

    /**
     * Take two or more Specification as parameters
     */
    public function __construct()
    {
        $this->children = func_get_args();
    }

    /**
     * Get the logic expression that may bind together two or more Specification.
     * This must be a function of $qb->expr()
     *
     * Examples: 'andX', 'orX'
     *
     * @return string
     */
    abstract protected function getLogicExpression();

    /**
     *
     *
     * @param QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return Query\Expr|mixed
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        return call_user_func_array(
            array($qb->expr(), $this->getLogicExpression()),
            array_map(
                function (Specification $spec) use ($qb, $dqlAlias) {
                    return $spec->match($qb, $dqlAlias);
                },
                $this->children
            )
        );
    }

    /**
     *
     *
     * @param Query $query
     *
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