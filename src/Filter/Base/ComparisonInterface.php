<?php

namespace Happyr\DoctrineSpecification\Filter\Base;

interface ComparisonInterface
{
    /**
     * @return mixed Return value to compare against
     */
    public function getValue();
}
