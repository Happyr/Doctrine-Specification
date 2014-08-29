<?php

namespace Happyr\Doctrine\Specification\Comparison;

class GreaterOrEqualThan extends Comparison
{
    public function __construct($field, $value, $dqlAlias = null)
    {
        parent::__construct(self::GTE, $field, $value, $dqlAlias);
    }
}
