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

namespace Happyr\DoctrineSpecification\Operand\PlatformFunction;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\Operand;

/**
 * Substract the number of days from a given date. (Supported units are YEAR, MONTH, WEEK, DAY, HOUR, MINUTE, SECOND)
 */
final class DateSub implements Operand
{
    public const YEAR = 'YEAR';
    public const MONTH = 'MONTH';
    public const WEEK = 'WEEK';
    public const DAY = 'DAY';
    public const HOUR = 'HOUR';
    public const MINUTE = 'MINUTE';
    public const SECOND = 'SECOND';

    private const UNITS = [
        self::YEAR,
        self::MONTH,
        self::WEEK,
        self::DAY,
        self::HOUR,
        self::MINUTE,
        self::SECOND,
    ];

    /**
     * @var Operand
     */
    private $date;

    /**
     * @var Operand
     */
    private $value;

    /**
     * @var string
     */
    private $unit;

    /**
     * @param \DateTimeInterface|string|Operand $date
     * @param int|Operand                $value
     * @param string                     $unit
     */
    public function __construct($date, $value, string $unit)
    {
        if (!in_array(strtoupper($unit), self::UNITS, true)) {
            throw new InvalidArgumentException(sprintf(
                'The DATE_ADD() function support "%s" units, got "%s" instead.',
                implode('", "', self::UNITS),
                $unit
            ));
        }

        $this->date = ArgumentToOperandConverter::toField($date);
        $this->value = ArgumentToOperandConverter::toValue($value);
        $this->unit = $unit;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, string $context): string
    {
        $date = $this->date->transform($qb, $context);
        $value = $this->value->transform($qb, $context);

        return sprintf('DATE_SUB(%s, %s, \'%s\')', $date, $value, $this->unit);
    }

    /**
     * @param mixed[]|object $candidate
     *
     * @return \DateTimeImmutable
     */
    public function execute($candidate): \DateTimeImmutable
    {
        $date = $this->date->execute($candidate);
        $value = $this->value->execute($candidate);

        if (!$date instanceof \DateTimeInterface) {
            throw new InvalidArgumentException(sprintf(
                'The date should be instance of "%s", got "%s" instead.',
                \DateTimeInterface::class,
                is_object($date) ? get_class($date) : gettype($date)
            ));
        }

        if (!is_int($value) && !is_numeric($value) && !ctype_digit($value)) {
            throw new InvalidArgumentException(sprintf(
                'The value should be an integer, got "%s" instead.',
                gettype($value)
            ));
        }

        $new_date = new \DateTimeImmutable($date->format('Y-m-d H:i:s'), $date->getTimezone());

        return $new_date->modify(sprintf('-%d %s', $value, $this->unit));
    }
}
