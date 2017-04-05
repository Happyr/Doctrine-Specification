<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\DBAL\Types\Type;

final class DBALTypesResolver
{
    /**
     * The map of supported doctrine mapping types.
     *
     * @var array
     */
    private static $typesMap = array();

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
        if (!is_object($value)) {
            return null;
        }

        // maybe it's a ValueObject

        // try get type name from types map
        $className = get_class($value);
        if (isset(self::$typesMap[$className])) {
            return Type::getType(self::$typesMap[$className]);
        }

        // use class name as type name
        $classNameParts = explode('\\', $className);
        $typeName = array_pop($classNameParts);

        if (array_key_exists($typeName, Type::getTypesMap())) {
            return Type::getType($typeName);
        }

        return null;
    }

    /**
     * Adds a custom type to the type map for resolve Value Object.
     *
     * @param string $name      the name of the type
     * @param string $className the class name of the Value Object
     */
    public static function addType($name, $className)
    {
        self::$typesMap[$className] = $name;
    }
}
