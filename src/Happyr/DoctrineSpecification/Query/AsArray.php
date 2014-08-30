<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Specification;

/**
 * Class AsArray
 *
 * @author Benjamin Eberlei
 */
class AsArray implements Specification
{
    /**
     * @var Specification parent
     */
    private $parent;

    /**
     * @param Specification $parent
     */
    public function __construct(Specification $parent)
    {
        $this->parent = $parent;
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
        $query->setHydrationMode(Query::HYDRATE_ARRAY);
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
