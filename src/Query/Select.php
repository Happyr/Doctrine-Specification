<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;

class Select extends AbstractSelect
{
    /**
     * @param QueryBuilder $qb
     * @param string[]     $selections
     */
    protected function modifySelection(QueryBuilder $qb, array $selections)
    {
        $qb->select($selections);
    }
}
