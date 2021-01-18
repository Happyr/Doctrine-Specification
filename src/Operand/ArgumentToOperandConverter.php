<?php
declare(strict_types=1);

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

/**
 * This service is intended for backward compatibility and may be removed in the future.
 */
final class ArgumentToOperandConverter
{
    /**
     * Convert the argument into the field operand if it is a string and not an operand or into the value operand.
     *
     * @param Operand|string|mixed $argument
     *
     * @return Operand
     */
    public static function toField($argument): Operand
    {
        if (is_string($argument)) {
            return new Field($argument);
        }

        return self::toValue($argument);
    }

    /**
     * Convert the argument into the value operand if it is not an operand.
     *
     * @param Operand|mixed $argument
     *
     * @return Operand
     */
    public static function toValue($argument): Operand
    {
        if ($argument instanceof Operand) {
            return $argument;
        }

        return new Value($argument);
    }

    /**
     * Are all arguments is a operands?
     *
     * @param Operand[]|mixed[] $arguments
     *
     * @return bool
     */
    public static function isAllOperands(array $arguments): bool
    {
        foreach ($arguments as $argument) {
            if (!($argument instanceof Operand)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Convert all arguments to operands.
     *
     * @param Operand[]|mixed[] $arguments
     *
     * @return Operand[]
     */
    public static function convert(array $arguments): array
    {
        $operands = [];
        foreach (array_values($arguments) as $i => $argument) {
            // always try convert the first argument to the field operand
            if (0 === $i) {
                $argument = self::toField($argument);
            } else {
                $argument = self::toValue($argument);
            }

            $operands[] = $argument;
        }

        return $operands;
    }
}
