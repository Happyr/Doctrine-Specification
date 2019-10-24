<?php

namespace Happyr\DoctrineSpecification\Operand;

@trigger_error('The '.__NAMESPACE__.'\BitRightShift class is deprecated since version 1.1 and will be removed in 2.0.', E_USER_DEPRECATED);

/**
 * @deprecated This class is deprecated since version 1.1 and will be removed in 2.0.
 */
class BitRightShift extends Bitwise
{
    /**
     * @param Operand|string $field
     * @param Operand|string $value
     */
    public function __construct($field, $value)
    {
        parent::__construct(self::B_RS, $field, $value);
    }
}
