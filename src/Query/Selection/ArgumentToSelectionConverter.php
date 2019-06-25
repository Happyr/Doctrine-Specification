<?php

namespace Happyr\DoctrineSpecification\Query\Selection;

use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Query\AbstractSelect;

/**
 * This service is intended for backward compatibility and may be removed in the future.
 */
class ArgumentToSelectionConverter
{
    /**
     * Convert the argument into the field operand if it is not an selection.
     *
     * @param Selection|string  $argument
     * @param $dqlAlias
     * @param AbstractSelect    $instance
     *
     * @return Selection
     */
    public static function toSelection($argument, $dqlAlias, $instance)
    {
        if ($argument instanceof Selection) {
            return $argument;
        }

        return new Field($argument, $dqlAlias, $instance);
    }
}
