<?php

namespace Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Specification;

class Not implements Specification
{
    /**
     * @var Specification parent
     */
    private $parent;

    /**
     * @param Specification $spec
     */
    public function __construct(Specification $spec)
    {
        $this->parent = $spec;
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
        $this->parent->modify($query, $dqlAlias);
    }
}
