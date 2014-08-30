<?php

namespace Happyr\DoctrineSpecification\Comparison;

class NotEquals extends Comparison
{
    public function __construct($field, $value, $dqlAlias = null)
    {
        parent::__construct(self::NEQ, $field, $value, $dqlAlias);
    }
}
