<?php

namespace Happyr\DoctrineSpecification\Query\Selection;

class SelectAs extends AbstractSelectAs
{
    /**
     * @return string
     */
    protected function getAliasFormat()
    {
        return '(%s) AS %s';
    }
}
