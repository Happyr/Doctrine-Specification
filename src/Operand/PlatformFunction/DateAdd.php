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
 * Add the number of days to a given date. (Supported units are YEAR, MONTH, WEEK, DAY, HOUR, MINUTE, SECOND).
 */
final class DateAdd implements Operand
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
     * @var \DateTimeInterface|string|Operand
     */
    private $date;

    /**
     * @var int|Operand
     */
    private $value;

    /**
     * @var string
     */
    private $unit;

    /**
     * @param \DateTimeInterface|string|Operand $date
     * @param int|Operand                       $value
     * @param string                            $unit
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

        $this->date = $date;
        $this->value = $value;
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
        $date = ArgumentToOperandConverter::toField($this->date)->transform($qb, $context);
        $value = ArgumentToOperandConverter::toValue($this->value)->transform($qb, $context);

        return sprintf('DATE_ADD(%s, %s, \'%s\')', $date, $value, $this->unit);
    }

    /**
     * @param mixed[]|object $candidate
     * @param string|null    $context
     *
     * @return \DateTimeImmutable
     */
    public function execute($candidate, ?string $context = null): \DateTimeImmutable
    {
        $date = ArgumentToOperandConverter::toField($this->date)->execute($candidate, $context);
        $value = ArgumentToOperandConverter::toValue($this->value)->execute($candidate, $context);

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

        if (0 > (float) $value) {
            return $new_date->modify(sprintf('%d %s', $value, $this->unit));
        }

        return $new_date->modify(sprintf('+%d %s', $value, $this->unit));
    }
}
