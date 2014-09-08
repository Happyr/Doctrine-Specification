<?php

namespace Happyr\DoctrineSpecification\QueryOption;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;
use Happyr\DoctrineSpecification\QueryOption;

/**
 * Class Limit
 *
 * @author Tobias Nyholm
 */
class Limit implements QueryOption
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
     * @param Query $query
     */
    public function modifyQuery(Query $query)
    {
        $query->setMaxResults($this->limit);
    }
}