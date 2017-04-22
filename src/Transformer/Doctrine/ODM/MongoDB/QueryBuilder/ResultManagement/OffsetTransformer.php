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
use Happyr\DoctrineSpecification\ResultManagement\Offset;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ODM\MongoDB\QueryBuilder\QueryBuilderTransformer;

class OffsetTransformer implements QueryBuilderTransformer
{
    /**
     * @param Specification $specification
     * @param Builder       $qb
     *
     * @return Builder
     */
    public function transform(Specification $specification, Builder $qb)
    {
        if ($specification instanceof Offset) {
            $qb->skip($specification->getOffset());
        }

        return $qb;
    }
}
