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

namespace Happyr\DoctrineSpecification\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException as DoctrineNonUniqueResultException;
use Doctrine\ORM\NoResultException as DoctrineNoResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\NonUniqueResultException;
use Happyr\DoctrineSpecification\Exception\NoResultException;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Result\ResultModifier;

/**
 * This trait should be used by a class extending \Doctrine\ORM\EntityRepository.
 */
trait EntitySpecificationRepositoryTrait
{
    /**
     * @var string
     */
    private $alias = 'root';

    /**
     * Get results when you match with a Specification.
     *
     * @param Filter|QueryModifier $specification
     * @param ResultModifier|null  $modifier
     *
     * @return mixed
     */
    public function match($specification, ?ResultModifier $modifier = null)
    {
        $query = $this->getQuery($specification, $modifier);

        return $query->execute();
    }

    /**
     * Get single result when you match with a Specification.
     *
     * @param Filter|QueryModifier $specification
     * @param ResultModifier|null  $modifier
     *
     * @throw Exception\NonUniqueException  If more than one result is found
     * @throw Exception\NoResultException   If no results found
     *
     * @return mixed
     */
    public function matchSingleResult($specification, ?ResultModifier $modifier = null)
    {
        $query = $this->getQuery($specification, $modifier);

        try {
            return $query->getSingleResult();
        } catch (DoctrineNonUniqueResultException $e) {
            throw new NonUniqueResultException($e->getMessage(), $e->getCode(), $e);
        } catch (DoctrineNoResultException $e) {
            throw new NoResultException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get single result or null when you match with a Specification.
     *
     * @param Filter|QueryModifier $specification
     * @param ResultModifier|null  $modifier
     *
     * @throw Exception\NonUniqueException  If more than one result is found
     *
     * @return mixed|null
     */
    public function matchOneOrNullResult($specification, ?ResultModifier $modifier = null)
    {
        try {
            return $this->matchSingleResult($specification, $modifier);
        } catch (NoResultException $e) {
            return null;
        }
    }

    /**
     * Get single scalar result when you match with a Specification.
     *
     * @param Filter|QueryModifier $specification
     * @param ResultModifier|null  $modifier
     *
     * @throw Exception\NonUniqueException  If more than one result is found
     * @throw Exception\NoResultException   If no results found
     *
     * @return mixed
     */
    public function matchSingleScalarResult($specification, ?ResultModifier $modifier = null)
    {
        $query = $this->getQuery($specification, $modifier);

        try {
            return $query->getSingleScalarResult();
        } catch (DoctrineNonUniqueResultException $e) {
            throw new NonUniqueResultException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get scalar result when you match with a Specification.
     *
     * @param Filter|QueryModifier $specification
     * @param ResultModifier|null  $modifier
     *
     * @throw Exception\NonUniqueException  If more than one result is found
     * @throw Exception\NoResultException   If no results found
     *
     * @return mixed
     */
    public function matchScalarResult($specification, ?ResultModifier $modifier = null)
    {
        $query = $this->getQuery($specification, $modifier);

        return $query->getScalarResult();
    }

    /**
     * Prepare a Query with a Specification.
     *
     * @param Filter|QueryModifier $specification
     * @param ResultModifier|null  $modifier
     *
     * @return Query
     */
    public function getQuery($specification, ?ResultModifier $modifier = null): AbstractQuery
    {
        $query = $this->getQueryBuilder($specification)->getQuery();

        if (null !== $modifier) {
            $modifier->modify($query);
        }

        return $query;
    }

    /**
     * @param Filter|QueryModifier $specification
     * @param string|null          $alias
     *
     * @return QueryBuilder
     */
    public function getQueryBuilder($specification, ?string $alias = null): QueryBuilder
    {
        $qb = $this->createQueryBuilder($alias ?: $this->getAlias());
        $this->applySpecification($qb, $specification, $alias);

        return $qb;
    }

    /**
     * Iterate results when you match with a Specification.
     *
     * @param Filter|QueryModifier $specification
     * @param ResultModifier|null  $modifier
     *
     * @return \Traversable<mixed>
     */
    public function iterate($specification, ?ResultModifier $modifier = null): \Traversable
    {
        $query = $this->getQuery($specification, $modifier);

        if (method_exists($query, 'toIterable')) {
            yield from $query->toIterable();
        } else {
            foreach ($query->iterate() as $key => $row) {
                yield $key => current($row);
            }
        }
    }

    /**
     * @param string $alias
     */
    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @param QueryBuilder         $queryBuilder
     * @param Filter|QueryModifier $specification
     * @param string|null          $alias
     *
     * @throws \InvalidArgumentException
     */
    protected function applySpecification(
        QueryBuilder $queryBuilder,
        $specification = null,
        ?string $alias = null
    ): void {
        if ($specification instanceof QueryModifier) {
            $specification->modify($queryBuilder, $alias ?: $this->getAlias());
        }

        if ($specification instanceof Filter) {
            $filter = $specification->getFilter($queryBuilder, $alias ?: $this->getAlias());
            $filter = trim($filter);

            if ('' !== $filter) {
                $queryBuilder->andWhere($filter);
            }
        }
    }
}
