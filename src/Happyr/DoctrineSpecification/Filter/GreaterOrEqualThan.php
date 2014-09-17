<?php

namespace Happyr\DoctrineSpecification\Filter;

class GreaterOrEqualThan extends Comparison
{
    public function __construct($field, $value, $dqlAlias = null)
    {
        parent::__construct(self::GTE, $field, $value, $dqlAlias);
    }
}
