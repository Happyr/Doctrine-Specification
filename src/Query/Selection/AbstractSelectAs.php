<?php

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
    private $alias = '';

    /**
     * @param Filter|Operand|string $expression
     * @param string                $alias
     */
    public function __construct($expression, $alias)
    {
        $this->expression = $expression;
        $this->alias = $alias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->expression instanceof Filter) {
            $expression = $this->expression->getFilter($qb, $dqlAlias);
        } else {
            $expression = ArgumentToOperandConverter::toField($this->expression);
            $expression = $expression->transform($qb, $dqlAlias);
        }

        return sprintf($this->getAliasFormat(), $expression, $this->alias);
    }

    /**
     * Return a select format.
     *
     * @return string
     */
    abstract protected function getAliasFormat();
}
