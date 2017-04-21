<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\QueryModifier;

use Doctrine\ORM\QueryBuilder;

abstract class AbstractJoin implements QueryModifier
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $newAlias;

    /**
     * @var string
     */
    private $dqlAlias;

    /**
     * @param string $field
     * @param string $newAlias
     * @param string $dqlAlias
     */
    public function __construct($field, $newAlias, $dqlAlias = null)
    {
        $this->field = $field;
        $this->newAlias = $newAlias;
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        $join = $this->getJoinType();
        $qb->$join(sprintf('%s.%s', $dqlAlias, $this->field), $this->newAlias);
    }

    /**
     * Return a join type (ie a function of QueryBuilder) like: "join", "innerJoin", "leftJoin".
     *
     * @return string
     */
    abstract public function getJoinType();
}
