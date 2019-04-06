<?php

namespace Happyr\DoctrineSpecification\Query;

class AddSelect extends AbstractSelect
{
    /**
     * @return string
     */
    protected function getSelectType()
    {
        return 'addSelect';
    }
}
