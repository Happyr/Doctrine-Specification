<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\EntityRepository;

class EntitySpecificationRepository extends EntityRepository
{
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
        $qb = $this->createQueryBuilder($this->alias);

        $specification->modify($qb, $this->alias);
        $query = $qb->where($specification->getFilter($qb, $this->alias))->getQuery();

        if ($modifier instanceof Result\ResultModifier) {
            $modifier->modify($query);
        }

        return $query->execute();
    }
}
