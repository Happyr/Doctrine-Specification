<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class Join extends AbstractJoin
{
    /**
     * {@inheritdoc}
     */
    protected function getJoinType()
    {
        return 'join';
    }
}
