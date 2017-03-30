<?php

namespace Happyr\DoctrineSpecification\Specification;

use Doctrine\ORM\QueryBuilder;

/**
 * @author Tobias Nyholm
 */
class CountOf implements Specification
{
    /**
     * @var Specification child
     */
    private $child;

    /**
     * @param Specification $child
     */
    public function __construct(Specification $child)
    {
        $this->child = $child;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, $dqlAlias)
    {
        $qb->select(sprintf('COUNT(%s)', $dqlAlias));

        return $this->child->getFilter($qb, $dqlAlias);
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $this->child->modify($qb, $dqlAlias);
    }
}
