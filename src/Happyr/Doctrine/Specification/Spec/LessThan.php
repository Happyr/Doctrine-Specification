<?php

namespace Happyr\Doctrine\Specification\Spec;

class LessThan extends Comparison
{
    public function __construct($operator, $field, $value, $dqlAlias = null)
    {
        parent::__construct(self::LT, $field, $value, $dqlAlias);
    }
}
