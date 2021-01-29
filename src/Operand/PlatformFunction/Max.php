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
use Happyr\DoctrineSpecification\Exception\OperandNotExecuteException;
use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\Operand;

final class Max implements Operand
{
    /**
     * @var Operand|string
     */
    private $field;

    /**
     * @var bool
     */
    private $distinct;

    /**
     * @param Operand|string $field
     * @param bool           $distinct
     */
    public function __construct($field, bool $distinct = false)
    {
        $this->field = $field;
        $this->distinct = $distinct;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, string $context): string
    {
        $field = ArgumentToOperandConverter::toField($this->field);
        $field = $field->transform($qb, $context);

        $expression = '';

        if ($this->distinct) {
            $expression = 'DISTINCT ';
        }

        return sprintf('MAX(%s%s)', $expression, $field);
    }

    /**
     * @param mixed[]|object $candidate
     * @param string|null    $context
     */
    public function execute($candidate, ?string $context = null): void
    {
        throw new OperandNotExecuteException(
            sprintf('The operand "%s" cannot be executed for a single candidate.', self::class)
        );
    }
}
