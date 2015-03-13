<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Specification;

class Cache implements Specification
{
    /**
     * @var Specification
     */
    private $parent;

    /**
     * @var integer How long the cache entry is valid
     */
    private $cacheLifetime;

    /**
     * @param Specification $parentSpecification Specification to decorate
     * @param integer       $cacheLifetime       How long the cache entry is valid
     */
    public function __construct(Specification $parentSpecification, $cacheLifetime)
    {
        $this->parent = $parentSpecification;
        $this->cacheLifetime = $cacheLifetime;
    }

    /**
     * @param QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return Expr
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        return $this->parent->match($qb, $dqlAlias);
    }

    /**
     * @param AbstractQuery $query
     */
    public function modifyQuery(AbstractQuery $query)
    {
        $query->setResultCacheLifetime($this->cacheLifetime);
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
