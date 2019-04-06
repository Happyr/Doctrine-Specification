<?php

namespace Happyr\DoctrineSpecification\Operand;

class Div extends Arithmetic
{
    /**
     * @param Operand|string $field
     * @param Operand|string $value
     */
    public function __construct($field, $value)
    {
        parent::__construct(self::DIV, $field, $value);
    }
}
