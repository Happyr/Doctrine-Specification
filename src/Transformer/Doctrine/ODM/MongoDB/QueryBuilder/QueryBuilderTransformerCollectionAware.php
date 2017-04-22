<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ODM\MongoDB\QueryBuilder;

interface QueryBuilderTransformerCollectionAware extends QueryBuilderTransformer
{
    /**
     * @param QueryBuilderTransformerCollection $collection
     */
    public function setCollection(QueryBuilderTransformerCollection $collection);
}
