<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @author Tobias Nyholm
 */
class Not implements Specification
{
    /**
     * @var Specification parent
     *
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
     * @return Query\Expr|mixed
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        return $qb->expr()->not($this->parent->match($qb, $dqlAlias));
    }

    /**
     * @param Query $query
     */
    public function modifyQuery(AbstractQuery $query)
    {
        $this->parent->modifyQuery($query);
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