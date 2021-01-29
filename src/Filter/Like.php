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

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\LikePattern;
use Happyr\DoctrineSpecification\Operand\Operand;

final class Like implements Filter, Satisfiable
{
    public const CONTAINS = LikePattern::CONTAINS;

    public const ENDS_WITH = LikePattern::ENDS_WITH;

    public const STARTS_WITH = LikePattern::STARTS_WITH;

    /**
     * @var Operand|string
     */
    private $field;

    /**
     * @var LikePattern
     */
    private $value;

    /**
     * @var string|null
     */
    private $context;

    /**
     * @param Operand|string     $field
     * @param LikePattern|string $value
     * @param string             $format
     * @param string|null        $context
     */
    public function __construct($field, $value, string $format = LikePattern::CONTAINS, ?string $context = null)
    {
        if (!($value instanceof LikePattern)) {
            $value = new LikePattern($value, $format);
        }

        $this->field = $field;
        $this->value = $value;
        $this->context = $context;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, string $context): string
    {
        if (null !== $this->context) {
            $context = sprintf('%s.%s', $context, $this->context);
        }

        $field = ArgumentToOperandConverter::toField($this->field);

        $field = $field->transform($qb, $context);
        $value = $this->value->transform($qb, $context);

        return (string) new DoctrineComparison($field, 'LIKE', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function filterCollection(iterable $collection, ?string $context = null): iterable
    {
        $context = $this->resolveContext($context);
        $field = ArgumentToOperandConverter::toField($this->field);
        $value = $this->getUnescapedValue();

        foreach ($collection as $candidate) {
            if ($this->isMatch($field->execute($candidate, $context), $value)) {
                yield $candidate;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy($candidate, ?string $context = null): bool
    {
        $context = $this->resolveContext($context);
        $field = ArgumentToOperandConverter::toField($this->field);
        $value = $this->getUnescapedValue();

        return $this->isMatch($field->execute($candidate, $context), $value);
    }

    /**
     * @param string|null $context
     *
     * @return string|null
     */
    private function resolveContext(?string $context): ?string
    {
        if (null !== $this->context && null !== $context) {
            return sprintf('%s.%s', $context, $this->context);
        }

        if (null !== $this->context) {
            return $this->context;
        }

        return $context;
    }

    /**
     * @return string
     */
    private function getUnescapedValue(): string
    {
        // remove escaping
        return str_replace('%%', '%', $this->value->getValue());
    }

    /**
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    private function isMatch(string $haystack, string $needle): bool
    {
        switch ($this->value->getFormat()) {
            case LikePattern::STARTS_WITH:
                return str_starts_with($haystack, $needle);

            case LikePattern::ENDS_WITH:
                return str_ends_with($haystack, $needle);

            default:
                return str_contains($haystack, $needle);
        }
    }
}
