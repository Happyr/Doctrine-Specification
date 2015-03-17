<?php

namespace Happyr\DoctrineSpecification;

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
     * @param $alias
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    abstract public function createQueryBuilder($alias);

    /**
     * Get result when you match with a Specification.
     *
     * @param Specification         $specification
     * @param Result\ResultModifier $modifier
     *
     * @return mixed
     */
    public function match(Specification $specification, Result\ResultModifier $modifier = null)
    {
        $alias = $this->alias;
        $qb = $this->createQueryBuilder($alias);

        $specification->modify($qb, $alias);
        $query = $qb->where($specification->getFilter($qb, $alias))->getQuery();

        if ($modifier !== null) {
            $modifier->modify($query);
        }

        return $query->execute();
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
