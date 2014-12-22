<?php

namespace Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Specification;

class Not
{
    /**
     * @var Filter parent
     */
    private $parent;

    /**
     * @param Filter $expr
     */
    public function __construct(Filter $expr)
    {
        $this->parent = $expr;
    }

    /**
     * @param QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, $dqlAlias)
    {
        return (string) $qb->expr()->not($this->parent->getFilter($qb, $dqlAlias));
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
