<?php

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

class IsNotNull implements Filter
{
    /**
     * @var string field
     */
    private $field;

    /**
     * @var null|string dqlAlias
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
    public function getFilter(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        return (string) $qb->expr()->isNotNull(sprintf('%s.%s', $dqlAlias, $this->field));
    }
}
