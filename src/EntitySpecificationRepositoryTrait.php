<?php

namespace Happyr\DoctrineSpecification;

/**
 * This trait should be used by a class extending \Doctrine\ORM\EntityRepository
 */
trait EntitySpecificationRepositoryTrait
{
    /**
     * @var string alias
     */
    private $alias = 'e';

    /**
     * Get result when you match with a Specification
     *
     * @param Specification   $specification
     * @param Result\ResultModifier $modifier
     *
     * @return mixed
     */
    public function match(Specification $specification, Result\ResultModifier $modifier = null)
    {
        $alias = $this->alias;
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $this->createQueryBuilder($alias);

        $specification->modify($qb, $alias);
        $query = $qb->where($specification->getFilter($qb, $alias))->getQuery();

        if ($modifier instanceof Result\ResultModifier) {
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
