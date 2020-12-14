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
use Happyr\DoctrineSpecification\Exception\OperandNotExecuteException;

final class CountDistinct implements Operand
{
    /**
     * @var Operand|string
     */
    private $field;

    /**
     * @param Operand|string $field
     */
    public function __construct($field)
    {
        $this->field = $field;
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

        return sprintf('COUNT(DISTINCT %s)', $field);
    }

    /**
     * @param mixed[]|object $candidate
     */
    public function execute($candidate): void
    {
        throw new OperandNotExecuteException(
            sprintf('The operand "%s" cannot be executed for a single candidate.', self::class)
        );
    }
}
