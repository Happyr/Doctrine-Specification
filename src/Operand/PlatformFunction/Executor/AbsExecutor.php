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

final class AbsExecutor
{
    /**
     * @param mixed $arithmetic_expression
     *
     * @return float|int
     */
    public function __invoke($arithmetic_expression)
    {
        return abs($arithmetic_expression);
    }
}
