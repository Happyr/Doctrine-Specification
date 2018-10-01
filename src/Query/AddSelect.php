<?php

namespace Happyr\DoctrineSpecification\Query;


use Doctrine\ORM\QueryBuilder;

class AddSelect implements QueryModifier
{
    private $alias;

    public function __construct($alias)
    {

        $this->alias = $alias;
    }

    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $qb->addSelect($this->alias);
    }
}