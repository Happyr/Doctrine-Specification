<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\ResultManagement;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\ResultManagement\Slice;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformer;

class SliceTransformer implements QueryBuilderTransformer
{
    /**
     * @param Specification $specification
     * @param QueryBuilder  $qb
     * @param string        $dqlAlias
     *
     * @return string|null
     */
    public function transform(Specification $specification, QueryBuilder $qb, $dqlAlias)
    {
        if ($specification instanceof Slice) {
            $qb->setMaxResults($specification->getSliceSize());

            if ($specification->getSliceNumber() > 0) {
                $qb->setFirstResult($specification->getSliceNumber() * $specification->getSliceSize());
            }
        }

        return null;
    }
}
