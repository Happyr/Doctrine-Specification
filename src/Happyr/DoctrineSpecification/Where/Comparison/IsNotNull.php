<?php

namespace Happyr\DoctrineSpecification\Where\Comparison;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Specification;

/**
 * Class IsNotNull
 *
 * @author Tobias Nyholm
 */
class IsNotNull implements Specification
{
    /**
     * @var string field
     *
     */
    private $field;

    /**
     * @var null|string dqlAlias
     *
     */
    private $dqlAlias;

    /**
     * Make sure the $field IS NOT NULL
     *
     * @param string $field
     * @param string $dqlAlias
     */
    public function __construct($field, $dqlAlias = null)
    {
        $this->field = $field;
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return Expr
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        return $qb->expr()->isNotNull(sprintf('%s.%s', $dqlAlias, $this->field));
    }
}
