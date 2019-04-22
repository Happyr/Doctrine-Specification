<?php

namespace Happyr\DoctrineSpecification\Query\Selection;

use Doctrine\ORM\QueryBuilder;

interface Selection
{
    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, $dqlAlias);
}
