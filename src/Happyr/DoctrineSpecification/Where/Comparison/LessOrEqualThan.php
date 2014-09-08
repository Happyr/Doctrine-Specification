<?php

namespace Happyr\DoctrineSpecification\Where\Comparison;

class LessOrEqualThan extends Comparison
{
    public function __construct($field, $value, $dqlAlias = null)
    {
        parent::__construct(self::LTE, $field, $value, $dqlAlias);
    }
}
