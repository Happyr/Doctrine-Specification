<?php

namespace Happyr\DoctrineSpecification\QueryModifier;

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
