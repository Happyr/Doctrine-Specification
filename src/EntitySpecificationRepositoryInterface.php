<?php

namespace Happyr\DoctrineSpecification;

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
     * @param ResultModifier       $modifier
     *
     * @return mixed[]
     */
    public function match($specification, ResultModifier $modifier);

    /**
     * Get single result when you match with a Specification.
     *
     * @param Filter|QueryModifier $specification
     * @param ResultModifier       $modifier
     *
     * @throw Exception\NonUniqueException  If more than one result is found
     * @throw Exception\NoResultException   If no results found
     *
     * @return mixed
     */
    public function matchSingleResult($specification, ResultModifier $modifier);

    /**
     * Get single result or null when you match with a Specification.
     *
     * @param Filter|QueryModifier $specification
     * @param ResultModifier       $modifier
     *
     * @throw Exception\NonUniqueException  If more than one result is found
     *
     * @return mixed|null
     */
    public function matchOneOrNullResult($specification, ResultModifier $modifier);

    /**
     * Prepare a Query with a Specification.
     *
     * @param Filter|QueryModifier $specification
     * @param ResultModifier       $modifier
     *
     * @return \Doctrine\ORM\Query
     */
    public function getQuery($specification, ResultModifier $modifier);

    /**
     * Iterate results when you match with a Specification.
     *
     * @param Filter|QueryModifier $specification
     * @param ResultModifier       $modifier
     *
     * @return mixed[]
     */
    public function iterate($specification, ResultModifier $modifier);
}
