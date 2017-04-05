<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\DBAL\Types\Type;

abstract class DBALTypesResolver
{
    /**
     * Try get type for value.
     *
     * If type is not found return NULL.
     *
     * @param mixed $value
     *
     * @return Type|null
     */
    public static function tryGetTypeForValue($value)
    {
        if (is_object($value)) { // maybe it's a ValueObject
            // use class name as type name
            $classNameParts = explode('\\', get_class($value));
            $typeName = array_pop($classNameParts);

            if (array_key_exists($typeName, Type::getTypesMap())) {
                return Type::getType($typeName);
            }
        }

        return null;
    }
}
