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

final class IsNull implements Filter, Satisfiable
{
    /**
     * @var Operand|string
     */
    private $field;

    /**
     * @var string|null
     */
    private $context;

    /**
     * @param Operand|string $field
     * @param string|null    $context
     */
    public function __construct($field, ?string $context = null)
    {
        $this->field = $field;
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

        return (string) $qb->expr()->isNull($field->transform($qb, $context));
    }

    /**
     * {@inheritdoc}
     */
    public function filterCollection(iterable $collection, ?string $context = null): iterable
    {
        $context = $this->resolveContext($context);
        $field = ArgumentToOperandConverter::toField($this->field);

        foreach ($collection as $candidate) {
            if (null === $field->execute($candidate, $context)) {
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

        return null === $field->execute($candidate, $context);
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
}
