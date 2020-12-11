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

final class Not implements Specification, Satisfiable
{
    /**
     * @var Filter
     */
    private $child;

    /**
     * @param Filter $expr
     */
    public function __construct(Filter $expr)
    {
        $this->child = $expr;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, string $dqlAlias): string
    {
        return (string) $qb->expr()->not($this->child->getFilter($qb, $dqlAlias));
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, string $dqlAlias): void
    {
        if ($this->child instanceof QueryModifier) {
            $this->child->modify($qb, $dqlAlias);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function filterCollection(iterable $collection): iterable
    {
        if (!$this->child instanceof Satisfiable) {
            return $collection;
        }

        foreach ($collection as $candidate) {
            if (!$this->child->isSatisfiedBy($candidate)) {
                yield $candidate;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy($candidate): bool
    {
        if (!$this->child instanceof Satisfiable) {
            return true;
        }

        return !$this->child->isSatisfiedBy($candidate);
    }
}
