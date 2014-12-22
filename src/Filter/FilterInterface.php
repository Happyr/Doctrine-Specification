<?php

namespace Happyr\DoctrineSpecification\Filter;

interface FilterInterface
{
    /**
     * @return mixed Return field name to filter
     */
    public function getField();
}
