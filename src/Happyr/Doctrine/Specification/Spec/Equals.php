<?php

namespace Happyr\Doctrine\Specification\Spec;

class Equals extends Comparison
{
    public function __construct($operator, $field, $value, $dqlAlias = null)
    {
        parent::__construct(self::EQ, $field, $value, $dqlAlias);
    }
}
