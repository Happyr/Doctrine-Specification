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

namespace Happyr\DoctrineSpecification\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\DQLContextResolver;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Filter\Satisfiable;
use Happyr\DoctrineSpecification\Query\QueryModifier;

final class CountOf implements Specification
{
    /**
     * @var Filter|QueryModifier
     */
    private $child;

    /**
     * @param Filter|QueryModifier $child
     */
    public function __construct($child)
    {
        $this->child = $child;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, string $context): string
    {
        $dqlAlias = DQLContextResolver::resolveAlias($qb, $context);

        $qb->select(sprintf('COUNT(%s)', $dqlAlias));

        if ($this->child instanceof Filter) {
            return $this->child->getFilter($qb, $context);
        }

        return '';
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     */
    public function modify(QueryBuilder $qb, string $context): void
    {
        if ($this->child instanceof QueryModifier) {
            $this->child->modify($qb, $context);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function filterCollection(iterable $collection, ?string $context = null): iterable
    {
        if ($this->child instanceof Satisfiable) {
            return $this->child->filterCollection($collection, $context);
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy($candidate, ?string $context = null): bool
    {
        if ($this->child instanceof Satisfiable) {
            return $this->child->isSatisfiedBy($candidate, $context);
        }

        return true;
    }
}
