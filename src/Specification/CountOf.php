<?php

namespace Happyr\DoctrineSpecification\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;

/**
 * @author Tobias Nyholm
 */
class CountOf implements Specification
{
    /**
     * @var Filter|QueryModifier child
     */
    private $child;

    /**
     * @param Filter|QueryModifier $child
     */
    public function __construct($child)
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

        if ($this->child instanceof Filter) {
            return $this->child->getFilter($qb, $dqlAlias);
        }

        return '';
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->child instanceof QueryModifier) {
            $this->child->modify($qb, $dqlAlias);
        }
    }
}
