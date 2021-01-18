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

final class DateDiffExecutor
{
    /**
     * @param \DateTimeInterface $date1
     * @param \DateTimeInterface $date2
     *
     * @return \DateInterval
     */
    public function __invoke(\DateTimeInterface $date1, \DateTimeInterface $date2): \DateInterval
    {
        return $date1->diff($date2);
    }
}
