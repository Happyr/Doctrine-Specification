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

final class ModExecutor
{
    /**
     * @param float $a
     * @param float $b
     *
     * @return float
     */
    public function __invoke(float $a, float $b): float
    {
        return fmod($a, $b);
    }
}
