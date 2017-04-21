<?php

namespace Happyr\DoctrineSpecification\QueryModifier;

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
