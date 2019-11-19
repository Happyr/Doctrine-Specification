<?php

/**
 * This file is part of the Happyr Doctrine Specification package.
 *
 * (c) Tobias Nyholm <tobias@happyr.com>
 *     Kacper Gunia <kacper@gunia.me>
 *     Peter Gribanov <info@peter-gribanov.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Happyr\DoctrineSpecification\Operand;

@trigger_error('The '.__NAMESPACE__.'\BitOr class is deprecated since version 1.1 and will be removed in 2.0, use "'.__NAMESPACE__.'\PlatformFunction(\'BIT_AND\', $a, $b)" instead.', E_USER_DEPRECATED);

/**
 * @deprecated This class is deprecated since version 1.1 and will be removed in 2.0, use "PlatformFunction('BIT_AND', $a, $b)" instead.
 */
class BitAnd extends Bitwise
{
    /**
     * @param Operand|string $field
     * @param Operand|string $value
     */
    public function __construct($field, $value)
    {
        parent::__construct(self::B_AND, $field, $value);
    }
}
