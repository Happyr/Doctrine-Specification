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
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Filter\Satisfiable;
use Happyr\DoctrineSpecification\Query\QueryModifier;

/**
 * Extend this abstract class if you want to build a new spec with your domain logic.
 */
abstract class BaseSpecification implements Specification
{
    /**
     * @var string|null
     */
    private $context;

    /**
     * @param string|null $context
     */
    public function __construct(?string $context = null)
    {
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
        $spec = $this->getSpec();

        if ($spec instanceof Filter) {
            return $spec->getFilter($qb, $this->getContext($context));
        }

        return '';
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     */
    public function modify(QueryBuilder $qb, string $context): void
    {
        $spec = $this->getSpec();

        if ($spec instanceof QueryModifier) {
            $spec->modify($qb, $this->getContext($context));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function filterCollection(iterable $collection, ?string $context = null): iterable
    {
        $spec = $this->getSpec();

        if ($spec instanceof Satisfiable) {
            return $spec->filterCollection($collection, $this->resolveContext($context));
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy($candidate, ?string $context = null): bool
    {
        $spec = $this->getSpec();

        if ($spec instanceof Satisfiable) {
            return $spec->isSatisfiedBy($candidate, $this->resolveContext($context));
        }

        return true;
    }

    /**
     * Return all the specifications.
     *
     * @return Filter|QueryModifier
     */
    abstract protected function getSpec();

    /**
     * @param string $context
     *
     * @return string
     */
    private function getContext(string $context): string
    {
        if (null !== $this->context) {
            return sprintf('%s.%s', $context, $this->context);
        }

        return $context;
    }

    /**
     * @param string $context
     *
     * @return string
     */
    protected function getNestedContext(string $context): string
    {
        if (null !== $this->context) {
            return sprintf('%s.%s', $this->context, $context);
        }

        return $context;
    }

    /**
     * @param string|null $context
     *
     * @return string|null
     */
    private function resolveContext(?string $context): ?string
    {
        if (null !== $this->context && null !== $context) {
            return sprintf('%s.%s', $context, $this->context);
        }

        if (null !== $this->context) {
            return $this->context;
        }

        return $context;
    }
}
