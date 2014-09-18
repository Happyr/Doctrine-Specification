<?php

namespace Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Expression;
use Happyr\DoctrineSpecification\Specification;

class Not implements Specification
{
    /**
     * @var Expression parent
     */
    private $parent;

    /**
     * @param Expression $expr
     */
    public function __construct(Expression $expr)
    {
        $this->parent = $expr;
    }

    /**
     * @param QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return string
     */
    public function getExpression(QueryBuilder $qb, $dqlAlias)
    {
        return (string) $qb->expr()->not($this->parent->getExpression($qb, $dqlAlias));
    }

    /**
     * @param QueryBuilder $query
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $query, $dqlAlias)
    {
        if ($this->parent instanceof Specification) {
            $this->parent->modify($query, $dqlAlias);
        }
    }
}
