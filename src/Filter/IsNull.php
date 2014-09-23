<?php

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

class IsNull implements Filter
{
    /**
     * @var string field
     */
    protected $field;

    /**
     * @var null|string dqlAlias
     */
    private $dqlAlias;

    /**
     * @param string      $field
     * @param string|null $dqlAlias
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

        return (string) $qb->expr()->isNull(sprintf('%s.%s', $dqlAlias, $this->field));
    }
}
