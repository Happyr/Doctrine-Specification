<?php

namespace Happyr\Doctrine\Specification\Comparison;

class GreaterThan extends Comparison
{
    public function __construct($field, $value, $dqlAlias = null)
    {
        parent::__construct(self::GT, $field, $value, $dqlAlias);
    }
}
