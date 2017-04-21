<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\QueryModifier;

class InnerJoin extends AbstractJoin
{
    /**
     * Return a join type (ie a function of QueryBuilder) like: "join", "innerJoin", "leftJoin".
     *
     * @return string
     */
    public function getJoinType()
    {
        return 'innerJoin';
    }
}
