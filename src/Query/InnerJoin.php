<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class InnerJoin extends AbstractJoin
{
    /**
     * {@inheritdoc}
     */
    protected function getJoinType()
    {
        return 'innerJoin';
    }
}
