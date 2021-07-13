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
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Result\ResultModifier;

/**
 * This interface should be used by an EntityRepository implementing the Specification pattern.
 */
interface EntitySpecificationRepositoryInterface
{
    /**
     * Get results when you match with a Specification.
     *
     * @param Filter|QueryModifier $specification
     * @param ResultModifier|null  $modifier
     *
     * @return mixed
     */
    public function match($specification, ?ResultModifier $modifier = null);

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
    public function matchSingleResult($specification, ?ResultModifier $modifier = null);

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
    public function matchOneOrNullResult($specification, ?ResultModifier $modifier = null);

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
    public function matchSingleScalarResult($specification, ?ResultModifier $modifier = null);

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
    public function matchScalarResult($specification, ?ResultModifier $modifier = null);

    /**
     * Prepare a Query with a Specification.
     *
     * @param Filter|QueryModifier $specification
     * @param ResultModifier|null  $modifier
     *
     * @return Query
     */
    public function getQuery($specification, ?ResultModifier $modifier = null): AbstractQuery;

    /**
     * @param Filter|QueryModifier $specification
     * @param string|null          $alias
     *
     * @return QueryBuilder
     */
    public function getQueryBuilder($specification, ?string $alias = null): QueryBuilder;

    /**
     * Iterate results when you match with a Specification.
     *
     * @param Filter|QueryModifier $specification
     * @param ResultModifier|null  $modifier
     *
     * @return \Traversable<mixed>
     */
    public function iterate($specification, ?ResultModifier $modifier = null): \Traversable;
}
