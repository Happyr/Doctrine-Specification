<?php

namespace Happyr\DoctrineSpecification\Filter;

use Happyr\DoctrineSpecification\Operand\Operand;

class GreaterThan extends Comparison
{
    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     */
    public function __construct($field, $value, $dqlAlias = null)
    {
        parent::__construct(self::GT, $field, $value, $dqlAlias);
    }
}
