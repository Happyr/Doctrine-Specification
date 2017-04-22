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
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\QueryModifier\LeftJoin;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformerCollection;

class LeftJoinTransformer implements QueryBuilderTransformer
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
        if ($specification instanceof LeftJoin) {
            $qb->leftJoin(sprintf('%s.%s', $dqlAlias, $specification->getField()), $specification->getAlias());

            if ($specification->getWith() instanceof Filter) {
                $qb = $this->collection->transform($specification->getField(), $qb, $specification->getAlias());
            }
        }

        return $qb;
    }
}
