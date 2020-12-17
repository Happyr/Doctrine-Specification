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

use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;

final class DateSubExecutor
{
    private const UNITS = [
        'YEAR',
        'MONTH',
        'WEEK',
        'DAY',
        'HOUR',
        'MINUTE',
        'SECOND',
    ];

    /**
     * @param \DateTimeInterface $date
     * @param int                $value
     * @param string             $unit
     *
     * @throws InvalidArgumentException
     *
     * @return \DateTimeImmutable
     */
    public function __invoke(\DateTimeInterface $date, int $value, string $unit): \DateTimeImmutable
    {
        if (!in_array(strtoupper($unit), self::UNITS, true)) {
            throw new InvalidArgumentException(sprintf(
                'The DATE_SUB() function support "%s" units, got "%s" instead.',
                implode('", "', self::UNITS),
                $unit
            ));
        }

        $new_date = new \DateTimeImmutable($date->format(\DateTimeInterface::ISO8601));

        return $new_date->modify(sprintf('-%d %s', $value, $unit));
    }
}
