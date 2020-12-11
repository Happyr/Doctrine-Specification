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
    private $dqlAlias;

    /**
     * @param Operand|string $field
     * @param string|null    $dqlAlias
     */
    public function __construct($field, ?string $dqlAlias = null)
    {
        $this->field = $field;
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, string $dqlAlias): string
    {
        if (null !== $this->dqlAlias) {
            $dqlAlias = $this->dqlAlias;
        }

        $field = ArgumentToOperandConverter::toField($this->field);

        return (string) $qb->expr()->isNotNull($field->transform($qb, $dqlAlias));
    }

    /**
     * {@inheritdoc}
     */
    public function filterCollection(iterable $collection): iterable
    {
        $field = ArgumentToOperandConverter::toField($this->field);

        foreach ($collection as $candidate) {
            if (null !== $field->execute($candidate)) {
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

        return null !== $field->execute($candidate);
    }
}
