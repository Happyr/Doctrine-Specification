<?php

namespace Happyr\Doctrine\Specification\Spec;

class LessOrEqualThan extends Comparison
{
    public function __construct($operator, $field, $value, $dqlAlias = null)
    {
        parent::__construct(self::LTE, $field, $value, $dqlAlias);
    }
}
