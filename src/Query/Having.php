<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;

class Having implements QueryModifier
{
    /**
     * @var Filter|string
     */
    private $filter;

    /**
     * @param Filter|string $filter
     */
    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->filter instanceof Filter) {
            $qb->having($this->filter->getFilter($qb, $dqlAlias));
        } else {
            $qb->having($this->filter);
        }
    }
}
