<?php

namespace Happyr\DoctrineSpecification\Where\Comparison;

class LessThan extends Comparison
{
    public function __construct($field, $value, $dqlAlias = null)
    {
        parent::__construct(self::LT, $field, $value, $dqlAlias);
    }
}
