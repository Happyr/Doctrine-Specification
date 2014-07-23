<?php

namespace Happyr\Doctrine\Specification\Spec;

class NotEquals extends Comparison
{
    public function __construct($operator, $field, $value, $dqlAlias = null)
    {
        parent::__construct(self::NEQ, $field, $value, $dqlAlias);
    }
}
