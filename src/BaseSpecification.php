<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Specification\Specification;

/**
 * Extend this abstract class if you want to build a new spec with your domain logic.
 */
abstract class BaseSpecification implements Specification
{
    /**
     * @var string|null dqlAlias
     */
    private $dqlAlias = null;

    /**
     * @param string $dqlAlias
     */
    public function __construct($dqlAlias = null)
    {
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, $dqlAlias)
    {
        $spec = $this->getSpec();
        if ($spec instanceof Filter) {
            return $spec->getFilter($qb, $this->getAlias($dqlAlias));
        }

        return;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $spec = $this->getSpec();
        if ($spec instanceof QueryModifier) {
            $spec->modify($qb, $this->getAlias($dqlAlias));
        }
    }

    /**
     * Return all the specifications.
     *
     * @return Specification
     */
    protected function getSpec()
    {
        return;
    }

    /**
     * @param string $dqlAlias
     *
     * @return string
     */
    private function getAlias($dqlAlias)
    {
        if (null !== $this->dqlAlias) {
            return $this->dqlAlias;
        }

        return $dqlAlias;
    }
}
