<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine;

use Doctrine\ORM\QueryBuilder;

final class ValueConverter
{
    /**
     * @param mixed        $value
     * @param QueryBuilder $qb
     *
     * @return mixed
     */
    public static function convertToDatabaseValue($value, QueryBuilder $qb)
    {
        if ($type = DBALTypesResolver::tryGetTypeForValue($value)) {
            return $type->convertToDatabaseValue(
                $value,
                $qb->getEntityManager()->getConnection()->getDatabasePlatform()
            );
        }

        return $value;
    }
}
