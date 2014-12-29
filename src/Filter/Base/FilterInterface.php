<?php

namespace Happyr\DoctrineSpecification\Filter\Base;

interface FilterInterface
{
    /**
     * @return mixed Return field name to filter
     */
    public function getField();
}
