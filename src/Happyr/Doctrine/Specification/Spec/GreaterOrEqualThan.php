<?php

namespace Happyr\Doctrine\Specification\Spec;

class GreaterOrEqualThan extends Comparison
{
    public function __construct($operator, $field, $value, $dqlAlias = null)
    {
        parent::__construct(self::GTE, $field, $value, $dqlAlias);
    }
}
