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
use Happyr\DoctrineSpecification\ResultModifier\ResultModifier;
use Happyr\DoctrineSpecification\Specification;

/**
 * This trait should be used by a class extending \Doctrine\ORM\EntityRepository.
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
     * @param Specification  $specification
     * @param ResultModifier $modifier
     *
     * @return mixed[]
     */
    public function match(Specification $specification, ResultModifier $modifier = null)
    {
        return $this->getQuery($specification, $modifier)->execute();
    }

    /**
     * Get single result when you match with a Specification.
     *
     * @param Specification  $specification
     * @param ResultModifier $modifier
     *
     * @return mixed
     */
    public function matchSingleResult(Specification $specification, ResultModifier $modifier = null)
    {
        return $this->getQuery($specification, $modifier)->getSingleResult();
    }

    /**
     * Prepare a Query with a Specification.
     *
     * @param Specification  $specification
     * @param ResultModifier $modifier
     *
     * @return Query
     */
    public function getQuery(Specification $specification, ResultModifier $modifier = null)
    {
        /* @var $qb Builder */
        $qb = $this->createQueryBuilder();

        // apply specification
        if ($this->transformer instanceof DoctrineODMMongoDBTransformer) {
            return $this->transformer->transform($specification, $modifier, $qb);
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
