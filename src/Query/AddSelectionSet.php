<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;

/**
 * Class SelectionSet.
 */
class AddSelectionSet extends AbstractSelectionSet
{
    /**
     * {@inheritdoc}
     */
    protected function modifySelection(array $fields, QueryBuilder $qb)
    {
        $qb->addSelect($fields);
    }
}
