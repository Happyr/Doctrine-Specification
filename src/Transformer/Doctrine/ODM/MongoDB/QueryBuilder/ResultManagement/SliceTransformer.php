<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ODM\MongoDB\QueryBuilder\ResultManagement;

use Doctrine\ODM\MongoDB\Query\Builder;
use Happyr\DoctrineSpecification\ResultManagement\Slice;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ODM\MongoDB\QueryBuilder\QueryBuilderTransformer;

class SliceTransformer implements QueryBuilderTransformer
{
    /**
     * @param Specification $specification
     * @param Builder       $qb
     */
    public function transform(Specification $specification, Builder $qb)
    {
        if ($specification instanceof Slice) {
            $qb->limit($specification->getSliceSize());

            if ($specification->getSliceNumber() > 0) {
                $qb->skip($specification->getSliceNumber() * $specification->getSliceSize());
            }
        }
    }
}
