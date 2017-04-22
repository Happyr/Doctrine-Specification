<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM;

use Doctrine\ORM\Query;
use Happyr\DoctrineSpecification\ResultModifier\ResultModifier;
use Happyr\DoctrineSpecification\Specification;

/**
 * This interface should be used by an EntityRepository implementing the Specification pattern.
 */
interface EntitySpecificationRepositoryInterface
{
    /**
     * Get results when you match with a Specification.
     *
     * @param Specification  $specification
     * @param ResultModifier $modifier
     *
     * @return mixed[]
     */
    public function match(Specification $specification, ResultModifier $modifier);

    /**
     * Get single result when you match with a Specification.
     *
     * @param Specification  $specification
     * @param ResultModifier $modifier
     *
     * @throw NonUniqueException If more than one result is found
     * @throw NoResultException  If no results found
     *
     * @return mixed
     */
    public function matchSingleResult(Specification $specification, ResultModifier $modifier);

    /**
     * Get single result or null when you match with a Specification.
     *
     * @param Specification  $specification
     * @param ResultModifier $modifier
     *
     * @throw NonUniqueException If more than one result is found
     *
     * @return mixed|null
     */
    public function matchOneOrNullResult(Specification $specification, ResultModifier $modifier);

    /**
     * Prepare a Query with a Specification.
     *
     * @param Specification  $specification
     * @param ResultModifier $modifier
     *
     * @return Query
     */
    public function getQuery(Specification $specification, ResultModifier $modifier);

    /**
     * @param string $alias
     *
     * @return self
     */
    public function setAlias($alias);

    /**
     * @param DoctrineORMTransformer $transformer
     *
     * @return self
     */
    public function setTransformer(DoctrineORMTransformer $transformer);
}
