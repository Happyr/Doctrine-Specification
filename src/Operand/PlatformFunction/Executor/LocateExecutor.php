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

namespace Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor;

final class LocateExecutor
{
    /**
     * @param mixed  $needle
     * @param string $haystack
     * @param int    $offset
     *
     * @return int
     */
    public function __invoke($needle, string $haystack, int $offset = 0): int
    {
        $position = strpos($haystack, $needle, $offset);

        // in DQL position is shifted
        return false === $position ? 0 : $position + 1;
    }
}
