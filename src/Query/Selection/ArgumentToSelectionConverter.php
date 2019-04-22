<?php

namespace Happyr\DoctrineSpecification\Query\Selection;

use Happyr\DoctrineSpecification\Operand\Field;

/**
 * This service is intended for backward compatibility and may be removed in the future.
 */
class ArgumentToSelectionConverter
{
    /**
     * Convert the argument into the field operand if it is not an selection.
     *
     * @param Selection|string $argument
     *
     * @return Selection
     */
    public static function toSelection($argument)
    {
        if ($argument instanceof Selection) {
            return $argument;
        }

        return new Field($argument);
    }
}
