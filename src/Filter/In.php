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

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\Operand;

final class In implements Filter, Satisfiable
{
    /**
     * @var Operand|string
     */
    private $field;

    /**
     * @var Operand|mixed
     */
    private $value;

    /**
     * @var string|null
     */
    private $context;

    /**
     * Make sure the $field has a value equals to $value.
     *
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $context
     */
    public function __construct($field, $value, ?string $context = null)
    {
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
        $value = ArgumentToOperandConverter::toValue($this->value);

        return (string) $qb->expr()->in(
            $field->transform($qb, $context),
            $value->transform($qb, $context)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function filterCollection(iterable $collection, ?string $context = null): iterable
    {
        $context = $this->resolveContext($context);
        $field = ArgumentToOperandConverter::toField($this->field);
        $value = ArgumentToOperandConverter::toValue($this->value);

        foreach ($collection as $candidate) {
            if ($this->contains($field->execute($candidate, $context), $value->execute($candidate, $context))) {
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
        $value = ArgumentToOperandConverter::toValue($this->value);

        return $this->contains($field->execute($candidate, $context), $value->execute($candidate, $context));
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
     * @param mixed $field
     * @param mixed $value
     *
     * @return bool
     */
    private function contains($field, $value): bool
    {
        if ($value instanceof \Traversable) {
            $value = iterator_to_array($value);
        }

        return in_array($field, $value, true);
    }
}
