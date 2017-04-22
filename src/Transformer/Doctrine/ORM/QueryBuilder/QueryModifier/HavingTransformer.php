<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryModifier;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\QueryModifier\Having;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformerCollection;

class HavingTransformer implements QueryBuilderTransformer
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
        if ($specification instanceof Having) {
            // FIXME impossible implement in current architecture
//            $qb->having($this->collection->transform($specification->getFilter(), $qb, $dqlAlias));
        }

        return $qb;
    }
}
