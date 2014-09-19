<?php

namespace Happyr\DoctrineSpecification\Filter;

class Equals extends Comparison
{
    public function __construct($field, $value, $dqlAlias = null)
    {
        parent::__construct(self::EQ, $field, $value, $dqlAlias);
    }
}
