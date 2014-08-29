<?php

namespace Happyr\Doctrine\Specification\Comparison;

class LessOrEqualThan extends Comparison
{
    public function __construct($field, $value, $dqlAlias = null)
    {
        parent::__construct(self::LTE, $field, $value, $dqlAlias);
    }
}
