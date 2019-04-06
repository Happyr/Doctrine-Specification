<?php

namespace Happyr\DoctrineSpecification\Operand;

class BitXor extends Bitwise
{
    /**
     * @param Operand|string $field
     * @param Operand|string $value
     */
    public function __construct($field, $value)
    {
        parent::__construct(self::B_XOR, $field, $value);
    }
}
