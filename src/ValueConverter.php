<?php

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
