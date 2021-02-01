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

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\Operand;

/**
 * Using the NEW operator you can construct Data Transfer Objects (DTOs) directly from DQL queries.
 */
final class SelectNew implements QueryModifier
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var Operand[]|mixed[]
     */
    private $arguments;

    /**
     * @param string        $class
     * @param Operand|mixed ...$arguments
     *
     * @phpstan-param class-string $class
     */
    public function __construct(string $class, ...$arguments)
    {
        $this->class = $class;
        $this->arguments = $arguments;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     */
    public function modify(QueryBuilder $qb, string $context): void
    {
        $arguments = [];
        foreach (ArgumentToOperandConverter::convert($this->arguments) as $argument) {
            $arguments[] = $argument->transform($qb, $context);
        }

        $qb->select(sprintf('NEW %s(%s)', $this->class, implode(', ', $arguments)));
    }
}
