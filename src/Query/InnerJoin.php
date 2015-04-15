<?php

namespace Happyr\DoctrineSpecification\Query;

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
