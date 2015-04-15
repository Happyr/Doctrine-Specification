<?php

namespace Happyr\DoctrineSpecification\Query;

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
