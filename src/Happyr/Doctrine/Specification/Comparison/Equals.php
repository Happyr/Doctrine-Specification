<?php

namespace Happyr\Doctrine\Specification\Comparison;

class Equals extends Comparison
{
    public function __construct($field, $value, $dqlAlias = null)
    {
        parent::__construct(self::EQ, $field, $value, $dqlAlias);
    }
}
