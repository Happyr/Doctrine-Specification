<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;

class AddSelect extends AbstractSelect
{
    /**
     * @param QueryBuilder $qb
     * @param string[]     $selections
     */
    protected function modifySelection(QueryBuilder $qb, array $selections)
    {
        $qb->addSelect($selections);
    }
}
