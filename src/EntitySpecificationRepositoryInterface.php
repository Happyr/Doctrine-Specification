<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;

/**
 * This interface should be used by an EntityRepository implementing the Specification pattern.
 */
interface EntitySpecificationRepositoryInterface extends ObjectRepository, Selectable
{
    /**
     * Get results when you match with a Specification.
     *
     * @param Filter|QueryModifier  $specification
     * @param Result\ResultModifier $modifier
     *
     * @return mixed[]
     */
    public function match($specification, Result\ResultModifier $modifier);

    /**
     * Get single result when you match with a Specification.
     *
     * @param Filter|QueryModifier  $specification
     * @param Result\ResultModifier $modifier
     *
     * @throw Exception\NonUniqueException  If more than one result is found
     * @throw Exception\NoResultException   If no results found
     *
     * @return mixed
     */
    public function matchSingleResult($specification, Result\ResultModifier $modifier);

    /**
     * Get single result or null when you match with a Specification.
     *
     * @param Filter|QueryModifier  $specification
     * @param Result\ResultModifier $modifier
     *
     * @throw Exception\NonUniqueException  If more than one result is found
     *
     * @return mixed|null
     */
    public function matchOneOrNullResult($specification, Result\ResultModifier $modifier);

    /**
     * Prepare a Query with a Specification.
     *
     * @param Filter|QueryModifier  $specification
     * @param Result\ResultModifier $modifier
     *
     * @return \Doctrine\ORM\Query
     */
    public function getQuery($specification, Result\ResultModifier $modifier);
}
