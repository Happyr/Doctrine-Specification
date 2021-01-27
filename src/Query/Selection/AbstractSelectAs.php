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

namespace Happyr\DoctrineSpecification\Query\Selection;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\Operand;

abstract class AbstractSelectAs implements Selection
{
    /**
     * @var Operand|Filter|string
     */
    private $expression;

    /**
     * @var string
     */
    private $newAlias;

    /**
     * @param Filter|Operand|string $expression
     * @param string                $newAlias
     */
    public function __construct($expression, string $newAlias)
    {
        $this->expression = $expression;
        $this->newAlias = $newAlias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, string $context): string
    {
        if ($this->expression instanceof Filter) {
            $expression = $this->expression->getFilter($qb, $context);
        } else {
            $expression = ArgumentToOperandConverter::toField($this->expression);
            $expression = $expression->transform($qb, $context);
        }

        return sprintf($this->getAliasFormat(), $expression, $this->newAlias);
    }

    /**
     * Return a select format.
     *
     * @return string
     */
    abstract protected function getAliasFormat(): string;
}
