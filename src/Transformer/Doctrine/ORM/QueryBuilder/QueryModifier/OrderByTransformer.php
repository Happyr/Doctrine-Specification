<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryModifier;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\QueryModifier\OrderBy;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformer;

class OrderByTransformer implements QueryBuilderTransformer
{
    /**
     * @param Specification $specification
     * @param QueryBuilder  $qb
     * @param string        $dqlAlias
     *
     * @return QueryBuilder
     */
    public function transform(Specification $specification, QueryBuilder $qb, $dqlAlias)
    {
        if ($specification instanceof OrderBy) {
            $qb->addOrderBy(
                sprintf('%s.%s', $dqlAlias, $specification->getField()),
                $specification->getOrder()
            );
        }

        return $qb;
    }
}
