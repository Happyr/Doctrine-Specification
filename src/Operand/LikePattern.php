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

namespace Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\ValueConverter;

final class LikePattern implements Operand
{
    public const CONTAINS = '%%%s%%';

    public const ENDS_WITH = '%%%s';

    public const STARTS_WITH = '%s%%';

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $format;

    /**
     * @param string $value
     * @param string $format
     */
    public function __construct(string $value, string $format = self::CONTAINS)
    {
        $this->value = $value;
        $this->format = $format;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, string $context): string
    {
        $paramName = sprintf('comparison_%d', $qb->getParameters()->count());
        $value = ValueConverter::convertToDatabaseValue($this->value, $qb);
        $value = $this->formatValue($this->format, $value);
        $qb->setParameter($paramName, $value);

        return sprintf(':%s', $paramName);
    }

    /**
     * @param mixed[]|object $candidate
     * @param string|null    $context
     *
     * @return string
     */
    public function execute($candidate, ?string $context = null): string
    {
        return $this->formatValue($this->format, $this->value);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @param string $value
     *
     * @return string
     */
    private function formatValue(string $format, string $value): string
    {
        return sprintf($format, $value);
    }
}
