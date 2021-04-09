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

namespace Happyr\DoctrineSpecification;

use Doctrine\DBAL\Types\Type;

final class DBALTypesResolver
{
    /**
     * The map of supported Doctrine mapping types.
     *
     * @var array<string, string>
     */
    private static $typesMap = [];

    /**
     * Try get type for value.
     *
     * If type is not found return NULL.
     *
     * @param mixed $value
     *
     * @return Type|null
     */
    public static function tryGetTypeForValue($value): ?Type
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
        $classNameParts = explode('\\', str_replace('_', '\\', $className));
        $typeName = array_pop($classNameParts);

        if (null !== $typeName && array_key_exists($typeName, Type::getTypesMap())) {
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
    public static function addType(string $name, string $className): void
    {
        self::$typesMap[$className] = $name;
    }
}
