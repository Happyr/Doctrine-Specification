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

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

final class DQLContextResolver
{
    /**
     * @var bool
     */
    private static $deadJoinsProtection = true;

    /**
     * @var bool
     */
    private static $conflictProtection = true;

    /**
     * @var bool
     */
    private static $autoJoining = true;

    /**
     * @var bool
     */
    private static $alwaysUnique = false;

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public static function resolveAlias(QueryBuilder $qb, string $context): string
    {
        $dqlAliasParts = explode('.', $context);

        // any given alias can be used
        if (!self::$deadJoinsProtection) {
            return array_pop($dqlAliasParts);
        }

        // use alias without conflict protection and dead joins.
        // we do not check parent joins for the found join.
        if (!self::$conflictProtection) {
            $dqlAlias = end($dqlAliasParts);

            if (in_array($dqlAlias, $qb->getAllAliases(), true)) {
                return $dqlAlias;
            }

            reset($dqlAliasParts);
        }

        $dqlAlias = $rootAlias = array_shift($dqlAliasParts);

        // check all parts of context path
        while ([] !== $dqlAliasParts) {
            $field = array_shift($dqlAliasParts);
            $join = sprintf('%s.%s', $dqlAlias, $field);
            $joinPart = self::findJoin($qb, $rootAlias, $join);

            // use exists or create new join
            if (!$joinPart instanceof Join || !($dqlAlias = $joinPart->getAlias())) {
                $dqlAlias = self::getUniqueAlias($qb, $field);

                if (self::$autoJoining) {
                    $qb->join($join, $dqlAlias);
                }
            }
        }

        return $dqlAlias;
    }

    /**
     * @return bool
     */
    public static function isDeadJoinsProtectionEnabled(): bool
    {
        return self::$deadJoinsProtection;
    }

    public static function enableDeadJoinsProtection(): void
    {
        self::$deadJoinsProtection = true;
    }

    public static function disableDeadJoinsProtection(): void
    {
        self::$deadJoinsProtection = false;
    }

    /**
     * @return bool
     */
    public static function isConflictProtectionEnabled(): bool
    {
        return self::$conflictProtection;
    }

    public static function enableConflictProtection(): void
    {
        self::$conflictProtection = true;
    }

    public static function disableConflictProtection(): void
    {
        self::$conflictProtection = false;
    }

    /**
     * @return bool
     */
    public static function isAutoJoiningEnabled(): bool
    {
        return self::$autoJoining;
    }

    public static function enableAutoJoining(): void
    {
        self::$autoJoining = true;
    }

    public static function disableAutoJoining(): void
    {
        self::$autoJoining = false;
    }

    /**
     * @return bool
     */
    public static function isUniqueAliasAlwaysUsed(): bool
    {
        return self::$alwaysUnique;
    }

    public static function alwaysUseUniqueAlias(): void
    {
        self::$alwaysUnique = true;
    }

    public static function useUniqueAliasIfNecessary(): void
    {
        self::$alwaysUnique = false;
    }

    /**
     * Find configured relationship.
     *
     * @param QueryBuilder $qb
     * @param string       $rootAlias
     * @param string       $join
     *
     * @return Join|null
     */
    private static function findJoin(QueryBuilder $qb, string $rootAlias, string $join): ?Join
    {
        $joinParts = $qb->getDQLPart('join');

        if (!array_key_exists($rootAlias, $joinParts)) {
            return null;
        }

        foreach ($joinParts[$rootAlias] as $joinPart) {
            if ($joinPart instanceof Join && $joinPart->getJoin() === $join) {
                return $joinPart;
            }
        }

        return null;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    private static function getUniqueAlias(QueryBuilder $qb, string $dqlAlias): string
    {
        if (!self::$conflictProtection) {
            return $dqlAlias;
        }

        if (!self::$alwaysUnique && !in_array($dqlAlias, $qb->getAllAliases(), true)) {
            return $dqlAlias;
        }

        do {
            $newAlias = uniqid($dqlAlias);
        } while (in_array($newAlias, $qb->getAllAliases(), true));

        return $newAlias;
    }
}
