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
use Happyr\DoctrineSpecification\Filter\Satisfiable;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Specification\Specification;

/**
 * This class should be used when you combine two or more Expressions.
 */
abstract class LogicX implements Specification
{
    public const AND_X = 'andX';

    public const OR_X = 'orX';

    /**
     * @var string
     */
    private $expression;

    /**
     * @var Filter[]|QueryModifier[]
     */
    private $children;

    /**
     * Take two or more Expression as parameters.
     *
     * @param string               $expression
     * @param Filter|QueryModifier ...$children
     */
    public function __construct(string $expression, ...$children)
    {
        $this->expression = $expression;
        $this->children = $children;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, string $context): string
    {
        $children = [];
        foreach ($this->children as $spec) {
            if ($spec instanceof Filter) {
                $filter = $spec->getFilter($qb, $context);

                if ($filter) {
                    $children[] = $filter;
                }
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
     * @param QueryBuilder $qb
     * @param string       $context
     */
    public function modify(QueryBuilder $qb, string $context): void
    {
        foreach ($this->children as $child) {
            if ($child instanceof QueryModifier) {
                $child->modify($qb, $context);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function filterCollection(iterable $collection, ?string $context = null): iterable
    {
        foreach ($collection as $candidate) {
            if ($this->isSatisfiedBy($candidate, $context)) {
                yield $candidate;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy($candidate, ?string $context = null): bool
    {
        $has_satisfiable_children = false;

        foreach ($this->children as $child) {
            if (!$child instanceof Satisfiable) {
                continue;
            }

            $has_satisfiable_children = true;

            $satisfied = $child->isSatisfiedBy($candidate, $context);

            if ($satisfied && self::OR_X === $this->expression) {
                return true;
            }

            if (!$satisfied && self::AND_X === $this->expression) {
                return false;
            }
        }

        return !$has_satisfiable_children || self::AND_X === $this->expression;
    }

    /**
     * Add another child to this logic tree.
     *
     * @param Filter|QueryModifier $child
     */
    protected function append($child): void
    {
        $this->children[] = $child;
    }
}
