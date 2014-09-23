<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;

interface QueryModifier
{
    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     * @return void
     */
    public function modify(QueryBuilder $qb, $dqlAlias);
} 
