<?php

namespace Happyr\DoctrineSpecification\Filter;

interface ComparisonInterface
{
    /**
     * @return mixed Return value to compare against
     */
    public function getValue();
}
