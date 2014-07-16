<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class AsArray
 *
 * @author Benjamin Eberlei
 *
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
     * @param Query $query
     */
    public function modifyQuery(AbstractQuery $query)
    {
        $query->setHydrationMode(Query::HYDRATE_ARRAY);
    }

    /**
     * @param QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return Query\Expr
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        return $this->parent->match($qb, $dqlAlias);
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