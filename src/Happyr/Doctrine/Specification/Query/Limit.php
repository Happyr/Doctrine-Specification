<?php

namespace Happyr\Doctrine\Specification\Query;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use Happyr\Doctrine\Specification\Specification;

/**
 * Class Limit
 *
 * @author Tobias Nyholm
 */
class Limit implements Specification
{
    /**
     * @var int limit
     */
    protected $limit;

    /**
     * @param int $limit
     */
    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param string $dqlAlias
     *
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        $qb->setMaxResults($this->limit);
    }

    /**
     * @param \Doctrine\ORM\AbstractQuery $query
     */
    public function modifyQuery(AbstractQuery $query)
    {
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