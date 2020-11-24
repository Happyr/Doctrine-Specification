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
