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

class Offset implements QueryModifier
{
    /**
     * @var int offset
     */
    protected $offset;

    /**
     * @param int $offset
     */
    public function __construct($offset)
    {
        $this->offset = $offset;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $qb->setFirstResult($this->offset);
    }
}
