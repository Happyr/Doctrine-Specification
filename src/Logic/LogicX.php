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

namespace Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Specification\Specification;

/**
 * This class should be used when you combine two or more Expressions.
 */
abstract class LogicX implements Specification
{
    const AND_X = 'andX';

    const OR_X = 'orX';

    /**
     * @var Filter[]|QueryModifier[]
     */
    private $children;

    /**
     * @var string
     */
    private $expression;

    /**
     * Take two or more Expression as parameters.
     *
     * @param string                   $expression
     * @param Filter[]|QueryModifier[] $children
     */
    public function __construct($expression, array $children = [])
    {
        $this->expression = $expression;
        $this->children = $children;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, $dqlAlias)
    {
        $children = [];
        foreach ($this->children as $spec) {
            if ($spec instanceof Filter && $filter = $spec->getFilter($qb, $dqlAlias)) {
                $children[] = $filter;
            }
        }

        if (!$children) {
            return '';
        }

        $expression = [$qb->expr(), $this->expression];

        if (!is_callable($expression)) {
            throw new \InvalidArgumentException(
                sprintf('Undefined "%s" method in "%s" class.', $this->expression, get_class($qb->expr()))
            );
        }

        return (string) call_user_func_array($expression, $children);
    }

    /**
     * @param QueryBuilder $query
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $query, $dqlAlias)
    {
        foreach ($this->children as $child) {
            if ($child instanceof QueryModifier) {
                $child->modify($query, $dqlAlias);
            }
        }
    }

    /**
     * Add another child to this logic tree.
     *
     * @param Filter|QueryModifier $child
     */
    protected function append($child)
    {
        $this->children[] = $child;
    }
}
