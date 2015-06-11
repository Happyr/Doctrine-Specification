<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Happyr\DoctrineSpecification\Specification\Specification;

/**
 * This trait should be used by a class extending \Doctrine\ORM\EntityRepository.
 */
trait EntitySpecificationRepositoryTrait
{
    /**
     * @var string alias
     */
    private $alias = 'e';

    /**
     * Get results when you match with a Specification.
     *
     * @param Specification         $specification
     * @param Result\ResultModifier $modifier
     *
     * @return mixed[]
     */
    public function match(Specification $specification, Result\ResultModifier $modifier = null)
    {
        $query = $this->getQuery($specification, $modifier);

        return $query->execute();
    }

    /**
     * Get single result when you match with a Specification.
     *
     * @param Specification         $specification
     * @param Result\ResultModifier $modifier
     *
     * @throw Exception\NonUniqueException  If more than one result is found
     * @throw Exception\NoResultException   If no results found
     *
     * @return mixed
     */
    public function matchSingleResult(Specification $specification, Result\ResultModifier $modifier = null)
    {
        $query = $this->getQuery($specification, $modifier);

        try {
            return $query->getSingleResult();
        } catch (NonUniqueResultException $e) {
            throw new Exception\NonUniqueResultException;
        } catch (NoResultException $e) {
            throw new Exception\NoResultException;
        }
    }


    /**
     * Get single result or null when you match with a Specification
     *
     * @param Specification         $specification
     * @param Result\ResultModifier $modifier
     *
     * @throw Exception\NonUniqueException  If more than one result is found
     *
     * @return mixed|null
     */
    public function matchOneOrNullResult(Specification $specification, Result\ResultModifier $modifier = null)
    {
        try {
            return $this->matchSingleResult($specification, $modifier);
        } catch (Exception\NoResultException $e) {
            return null;
        }
    }

    /**
     * Prepare a Query with a Specification.
     *
     * @param Specification         $specification
     * @param Result\ResultModifier $modifier
     *
     * @return \Doctrine\ORM\Query
     */
    public function getQuery(Specification $specification, Result\ResultModifier $modifier = null)
    {
        $alias = $this->alias;
        $qb = $this->createQueryBuilder($alias);

        $specification->modify($qb, $alias);
        $query = $qb->where($specification->getFilter($qb, $alias))->getQuery();

        if ($modifier !== null) {
            $modifier->modify($query);

            return $query;
        }

        return $query;
    }

    /**
     * @param string $alias
     *
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }
}
