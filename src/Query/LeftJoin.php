<?php

namespace Happyr\DoctrineSpecification\Query;

class LeftJoin extends AbstractJoin
{
    /**
     * {@inheritdoc}
     */
    protected function getJoinType()
    {
        return 'leftJoin';
    }
}
