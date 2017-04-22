<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ODM\MongoDB\QueryBuilder\Filter\Logic;

use Doctrine\ODM\MongoDB\Query\Builder;
use Happyr\DoctrineSpecification\Filter\Logic\AndX;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ODM\MongoDB\QueryBuilder\QueryBuilderTransformerCollectionAware;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ODM\MongoDB\QueryBuilder\QueryBuilderTransformerCollectionAwareTrait;

class AndXTransformer implements QueryBuilderTransformerCollectionAware
{
    use QueryBuilderTransformerCollectionAwareTrait;

    /**
     * @param Specification $specification
     * @param Builder       $qb
     */
    public function transform(Specification $specification, Builder $qb)
    {
        if ($specification instanceof AndX) {
            foreach ($specification->getFilters() as $filter) {
                $this->collection->transform($filter, $qb);
            }
        }
    }
}
