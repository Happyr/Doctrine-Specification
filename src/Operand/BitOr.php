<?php

namespace Happyr\DoctrineSpecification\Operand;

@trigger_error('The '.__NAMESPACE__.'\BitOr class is deprecated since version 1.1 and will be removed in 2.0, use "'.__NAMESPACE__.'\PlatformFunction(\'BIT_OR\', $a, $b)" instead.', E_USER_DEPRECATED);

/**
 * @deprecated This class is deprecated since version 1.1 and will be removed in 2.0, use "PlatformFunction('BIT_OR', $a, $b)" instead.
 */
class BitOr extends Bitwise
{
    /**
     * @param Operand|string $field
     * @param Operand|string $value
     */
    public function __construct($field, $value)
    {
        parent::__construct(self::B_OR, $field, $value);
    }
}
