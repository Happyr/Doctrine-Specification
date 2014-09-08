<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\EntityRepository;
use InvalidArgumentException;

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
     * @param QueryOption $queryModifier
     *
     * @throws InvalidArgumentException
     *
     * @return mixed
     */
    public function match(Specification $specification, QueryOption $queryModifier = null)
    {
        //check if the Specification is supported
        if (!$specification->supports($this->getEntityName())) {
            throw new InvalidArgumentException("Specification not supported by this repository.");
        }

        //get the Query Builder
        $qb = $this->createQueryBuilder('e');

        //match with the Specification
        $expr = $specification->match($qb, 'e');

        //add teh result expression in the where clause
        $query = $qb->where($expr)->getQuery();

        if ($queryModifier instanceof QueryOption) {
            $queryModifier->modifyQuery($query);
        }

        return $query->getResult();
    }
}
