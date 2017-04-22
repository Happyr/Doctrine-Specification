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
use Happyr\DoctrineSpecification\Transformer\Doctrine\ODM\MongoDB\QueryBuilder\QueryBuilderTransformerCollection;

class DoctrineODMMongoDBTransformer
{
    /**
     * @var QueryBuilderTransformerCollection
     */
    private $transformer;

    /**
     * @param QueryBuilderTransformerCollection $transformer
     */
    public function __construct(QueryBuilderTransformerCollection $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param Specification $specification
     * @param Builder       $qb
     *
     * @return Builder
     */
    public function transform(Specification $specification, Builder $qb)
    {
        $this->transformer->transform($specification, $qb);

        return $qb;
    }
}
