<?php

namespace Happyr\DoctrineSpecification\QueryModifier;

use Doctrine\ORM\QueryBuilder;

interface QueryModifier
{
    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias);
}
