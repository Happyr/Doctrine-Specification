<?php

namespace Happyr\DoctrineSpecification\Query;

class Select extends AbstractSelect
{
    /**
     * @return string
     */
    protected function getSelectType()
    {
        return 'select';
    }
}
