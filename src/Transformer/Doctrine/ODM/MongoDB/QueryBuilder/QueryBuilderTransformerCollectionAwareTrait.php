<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ODM\MongoDB\QueryBuilder;

trait QueryBuilderTransformerCollectionAwareTrait
{
    /**
     * @var QueryBuilderTransformerCollection
     */
    protected $collection;

    /**
     * @param QueryBuilderTransformerCollection $collection
     */
    public function setCollection(QueryBuilderTransformerCollection $collection)
    {
        $this->collection = $collection;
    }
}
