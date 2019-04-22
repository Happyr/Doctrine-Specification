<?php

namespace Happyr\DoctrineSpecification\Query\Selection;

class SelectHiddenAs extends AbstractSelectAs
{
    /**
     * @return string
     */
    protected function getAliasFormat()
    {
        return '(%s) AS HIDDEN %s';
    }
}
