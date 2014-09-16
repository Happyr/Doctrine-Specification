<?php

namespace Happyr\DoctrineSpecification\Where;

use Doctrine\ORM\QueryBuilder;

interface Expression
{
    /**
     * @param QueryBuilder $qb
     * @param              $dqlAlias
     *
     * @return string Logic expression
     */
    public function getExpression(QueryBuilder $qb, $dqlAlias);
}
