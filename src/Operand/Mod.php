<?php

namespace Happyr\DoctrineSpecification\Operand;

class Mod extends Arithmetic
{
    /**
     * @param Operand|string $field
     * @param Operand|string $value
     */
    public function __construct($field, $value)
    {
        parent::__construct(self::MOD, $field, $value);
    }
}
