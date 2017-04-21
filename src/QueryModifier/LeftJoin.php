<?php

namespace Happyr\DoctrineSpecification\QueryModifier;

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
