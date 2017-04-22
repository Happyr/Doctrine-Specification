<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ODM\MongoDB\QueryBuilder;

use Doctrine\ODM\MongoDB\Query\Builder;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\SpecificationCollection;

class SpecificationCollectionTransformer implements QueryBuilderTransformerCollectionAware
{
    use QueryBuilderTransformerCollectionAwareTrait;

    /**
     * @param Specification $specification
     * @param Builder       $qb
     */
    public function transform(Specification $specification, Builder $qb)
    {
        if ($specification instanceof SpecificationCollection) {
            foreach ($specification->getSpecifications() as $specification) {
                $this->collection->transform($specification, $qb);
            }
        }
    }
}
