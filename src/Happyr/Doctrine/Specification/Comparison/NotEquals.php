<?php

namespace Happyr\Doctrine\Specification\Comparison;

class NotEquals extends Comparison
{
    public function __construct($field, $value, $dqlAlias = null)
    {
        parent::__construct(self::NEQ, $field, $value, $dqlAlias);
    }
}
