<?php

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\QueryBuilder;

interface Filter
{
    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, $dqlAlias);
}
