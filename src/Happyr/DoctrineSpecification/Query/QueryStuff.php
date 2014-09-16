<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;

interface QueryStuff
{
    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function match(QueryBuilder $qb, $dqlAlias);
} 
