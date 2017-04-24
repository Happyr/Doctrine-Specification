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
use Happyr\DoctrineSpecification\Specification;

/**
 * This interface should be used by an DocumentRepository implementing the Specification pattern.
 */
interface EntitySpecificationRepositoryInterface
{
    /**
     * Get results when you match with a Specification.
     *
     * @param Specification $specification
     *
     * @return mixed[]
     */
    public function match(Specification $specification);

    /**
     * Get single result when you match with a Specification.
     *
     * @param Specification $specification
     *
     * @return mixed
     */
    public function matchSingleResult(Specification $specification);

    /**
     * Prepare a Query with a Specification.
     *
     * @param Specification $specification
     *
     * @return Builder
     */
    public function getQuery(Specification $specification);

    /**
     * @param DoctrineODMMongoDBTransformer $transformer
     *
     * @return self
     */
    public function setTransformer(DoctrineODMMongoDBTransformer $transformer);
}
