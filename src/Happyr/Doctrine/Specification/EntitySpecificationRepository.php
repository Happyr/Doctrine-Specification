<?php

namespace Happyr\Doctrine\Specification;

use Doctrine\ORM\EntityRepository;
use Happyr\Doctrine\Specification\Spec\Specification;

/**
 * Class EntitySpecificationRepository
 *
 * @author Benjamin Eberlei
 * @author Tobias Nyholm
 *
 */
class EntitySpecificationRepository extends EntityRepository
{
    /**
     * Get result when you match with a Specification
     *
     * @param Specification $specification
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function match(Specification $specification)
    {
        //check if the Specification is supported
        if (!$specification->supports($this->getEntityName())) {
            throw new \InvalidArgumentException("Specification not supported by this repository.");
        }

        //get the Query Builder
        $qb = $this->createQueryBuilder('e');

        //match with the Specification
        $expr = $specification->match($qb, 'e');

        //add teh result expression in the where clause
        $query = $qb->where($expr)->getQuery();

        //give the Specification a change to modify the query
        $specification->modifyQuery($query);

        //get and return the result
        return $query->getResult();
    }
}
