<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;

class GroupBy implements QueryModifier
{
    /**
     * @var int limit
     */
    protected $field;

    /**
     * @var string dqlAlias
     */
    protected $dqlAlias;

    /**
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
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if (null !== $this->dqlAlias) {
            $dqlAlias = $this->dqlAlias;
        }
        $qb->addGroupBy(sprintf('%s.%s', $dqlAlias, $this->field));
    }
}
