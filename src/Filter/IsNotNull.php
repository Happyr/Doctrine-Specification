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

final class IsNotNull implements Filter, Satisfiable
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

        return (string) $qb->expr()->isNotNull($field->transform($qb, $context));
    }

    /**
     * {@inheritdoc}
     */
    public function filterCollection(iterable $collection): iterable
    {
        $field = ArgumentToOperandConverter::toField($this->field);

        foreach ($collection as $candidate) {
            if (null !== $field->execute($candidate, $this->context)) {
                yield $candidate;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy($candidate): bool
    {
        $field = ArgumentToOperandConverter::toField($this->field);

        return null !== $field->execute($candidate, $this->context);
    }
}
