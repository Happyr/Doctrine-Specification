<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\FilterCollection;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformerCollection;

class FilterCollectionTransformer implements QueryBuilderTransformer
{
    /**
     * @var QueryBuilderTransformerCollection
     */
    private $collection;

    /**
     * @param QueryBuilderTransformerCollection $collection
     */
    public function __construct(QueryBuilderTransformerCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @param Specification $specification
     * @param QueryBuilder  $qb
     * @param string        $dqlAlias
     *
     * @return QueryBuilder
     */
    public function transform(Specification $specification, QueryBuilder $qb, $dqlAlias)
    {
        if ($specification instanceof FilterCollection) {
            foreach ($specification->getFilters() as $filter) {
                $qb = $this->collection->transform($filter, $qb, $dqlAlias);
            }
        }

        return $qb;
    }
}
