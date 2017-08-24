<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;

/**
 * Class SelectionSet.
 */
class SelectionSet extends AbstractSelectionSet
{
    /**
     * {@inheritdoc}
     */
    protected function modifySelection(array $fields, QueryBuilder $qb)
    {
        $qb->select($fields);
    }
}
