<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ODM\MongoDB;

use Doctrine\ODM\MongoDB\Query\Builder;
use Doctrine\ODM\MongoDB\Query\Query;
use Happyr\DoctrineSpecification\Specification;

/**
 * This trait should be used by a class extending \Doctrine\ODM\MongoDB\DocumentRepository.
 */
trait EntitySpecificationRepositoryTrait
{
    /**
     * @var DoctrineODMMongoDBTransformer
     */
    private $transformer;

    /**
     * Get results when you match with a Specification.
     *
     * @param Specification $specification
     *
     * @return mixed[]
     */
    public function match(Specification $specification)
    {
        return $this->getQuery($specification)->execute();
    }

    /**
     * Get single result when you match with a Specification.
     *
     * @param Specification $specification
     *
     * @return mixed
     */
    public function matchSingleResult(Specification $specification)
    {
        return $this->getQuery($specification)->getSingleResult();
    }

    /**
     * Prepare a Query with a Specification.
     *
     * @param Specification $specification
     *
     * @return Query
     */
    public function getQuery(Specification $specification)
    {
        /* @var $qb Builder */
        $qb = $this->createQueryBuilder();

        // apply specification
        if ($this->transformer instanceof DoctrineODMMongoDBTransformer) {
            return $this->transformer->transform($specification, $qb);
        } else {
            return $qb->getQuery();
        }
    }

    /**
     * @param DoctrineODMMongoDBTransformer $transformer
     *
     * @return self
     */
    public function setTransformer(DoctrineODMMongoDBTransformer $transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }
}
