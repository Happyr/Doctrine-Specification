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

final class MemberOfX implements Filter
{
    /**
     * @var Operand|string
     */
    private $field;

    /**
     * @var Operand|string
     */
    private $value;

    /**
     * @var string|null
     */
    private $context;

    /**
     * @param Operand|mixed  $value
     * @param Operand|string $field
     * @param string|null    $context
     */
    public function __construct($value, $field, ?string $context = null)
    {
        $this->value = $value;
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
        $value = ArgumentToOperandConverter::toValue($this->value);

        return (string) $qb->expr()->isMemberOf(
            $value->transform($qb, $context),
            $field->transform($qb, $context)
        );
    }
}
