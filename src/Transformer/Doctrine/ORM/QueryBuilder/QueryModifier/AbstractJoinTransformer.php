<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryModifier;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\QueryModifier\AbstractJoin;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformerCollection;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformerCollectionAware;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformerCollectionAwareTrait;

abstract class AbstractJoinTransformer implements QueryBuilderTransformerCollectionAware
{
    use QueryBuilderTransformerCollectionAwareTrait;

    /**
     * @param AbstractJoin $specification
     * @param QueryBuilder $qb
     *
     * @return string|null
     */
    protected function getCondition(AbstractJoin $specification, QueryBuilder $qb)
    {
        if (!($specification->getCondition() instanceof Filter) ||
            !($this->collection instanceof QueryBuilderTransformerCollection)
        ) {
            return null;
        }

        return $this->collection->transform($specification->getCondition(), $qb, $specification->getAlias());
    }

    /**
     * @param AbstractJoin $specification
     *
     * @return string
     */
    protected function getConditionType(AbstractJoin $specification)
    {
        return $specification->getConditionType() == AbstractJoin::ON ? Join::ON : Join::WITH;
    }
}
