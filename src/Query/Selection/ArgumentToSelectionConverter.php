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

namespace Happyr\DoctrineSpecification\Query\Selection;

use Happyr\DoctrineSpecification\Operand\Field;

/**
 * This service is intended for backward compatibility and may be removed in the future.
 */
final class ArgumentToSelectionConverter
{
    /**
     * Convert the argument into the field operand if it is not an selection.
     *
     * @param Selection|string $argument
     *
     * @return Selection
     */
    public static function toSelection($argument): Selection
    {
        if ($argument instanceof Selection) {
            return $argument;
        }

        return new Field($argument);
    }
}
