<?php

namespace Happyr\DoctrineSpecification\Where\Logic;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Where\Expression;

/**
 * @author Tobias Nyholm
 */
class Not implements Expression
{
    /**
     * @var Expression parent
     *
     */
    private $parent;

    /**
     * @param Expression $spec
     */
    public function __construct(Expression $spec)
    {
        $this->parent = $spec;
    }

    /**
     * @param QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return Expr|mixed
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        return $qb->expr()->not($this->parent->match($qb, $dqlAlias));
    }
}
