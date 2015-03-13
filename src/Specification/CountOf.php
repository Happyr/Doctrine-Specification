<?php

namespace Happyr\DoctrineSpecification\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Specification;

/**
 * @author Tobias Nyholm
 */
class CountOf implements Specification
{
    /**
     * @var \Happyr\DoctrineSpecification\Specification child
     */
    private $child;

    /**
     * @param Specification $child
     */
    public function __construct(Specification $child)
    {
        $this->child = $child;
    }

    public function getFilter(QueryBuilder $qb, $dqlAlias)
    {
        $qb->select(sprintf('COUNT(%s)', $dqlAlias));

        return $this->child->getFilter($qb, $dqlAlias);
    }

    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $this->child->modify($qb, $dqlAlias);
    }
}
