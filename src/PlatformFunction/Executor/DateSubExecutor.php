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

namespace Happyr\DoctrineSpecification\PlatformFunction\Executor;

final class DateSubExecutor
{
    private const UNITS = [
        'year',
        'month',
        'week',
        'day',
        'hour',
        'minute',
        'second',
    ];

    /**
     * @param \DateTimeInterface $date
     * @param int                $value
     * @param string             $unit
     *
     * @return \DateTimeImmutable
     */
    public function __invoke(\DateTimeInterface $date, int $value, string $unit): \DateTimeImmutable
    {
        $new_date = new \DateTimeImmutable($date->format(\DateTimeInterface::ISO8601));

        $unit = strtolower($unit);

        if (in_array($unit, self::UNITS, true)) {
            $new_date = $new_date->modify(sprintf('-%d %s', $value, $unit));
        }

        return $new_date;
    }
}
