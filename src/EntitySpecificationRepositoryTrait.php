<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Result\ResultModifier;

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
     * @param Filter|QueryModifier $specification
     * @param ResultModifier|null  $modifier
     *
     * @return mixed[]
     */
    public function match($specification, ResultModifier $modifier = null)
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
    public function matchSingleResult($specification, ResultModifier $modifier = null)
    {
        $query = $this->getQuery($specification, $modifier);

        try {
            return $query->getSingleResult();
        } catch (NonUniqueResultException $e) {
            throw new Exception\NonUniqueResultException($e->getMessage(), $e->getCode(), $e);
        } catch (NoResultException $e) {
            throw new Exception\NoResultException($e->getMessage(), $e->getCode(), $e);
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
    public function matchOneOrNullResult($specification, ResultModifier $modifier = null)
    {
        try {
            return $this->matchSingleResult($specification, $modifier);
        } catch (Exception\NoResultException $e) {
            return;
        }
    }

    /**
     * Prepare a Query with a Specification.
     *
     * @param Filter|QueryModifier $specification
     * @param ResultModifier|null  $modifier
     *
     * @return Query
     */
    public function getQuery($specification, ResultModifier $modifier = null)
    {
        $qb = $this->createQueryBuilder($this->alias);
        $this->applySpecification($qb, $specification);
        $query = $qb->getQuery();

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
    public function getQueryBuilder($specification, $alias = null)
    {
        $qb = $this->createQueryBuilder($alias ?: $this->getAlias());
        $this->applySpecification($qb, $specification, $alias);

        return $qb;
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

    /**
     * @param QueryBuilder         $queryBuilder
     * @param Filter|QueryModifier $specification
     * @param string               $alias
     *
     * @throws \InvalidArgumentException
     */
    protected function applySpecification(QueryBuilder $queryBuilder, $specification = null, $alias = null)
    {
        if (null === $specification) {
            return;
        }

        if (!$specification instanceof QueryModifier && !$specification instanceof Filter) {
            throw new \InvalidArgumentException(sprintf(
                'Expected argument of type "%s" or "%s", "%s" given.',
                'Happyr\DoctrineSpecification\Query\QueryModifier',
                'Happyr\DoctrineSpecification\Filter\Filter',
                is_object($specification) ? get_class($specification) : gettype($specification)
            ));
        }

        if ($specification instanceof QueryModifier) {
            $specification->modify($queryBuilder, $alias ?: $this->getAlias());
        }

        if ($specification instanceof Filter
            && $filter = (string) $specification->getFilter($queryBuilder, $alias ?: $this->getAlias())
        ) {
            $queryBuilder->andWhere($filter);
        }
    }
}
