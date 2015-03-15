<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;

/**
 * Class Join.
 */
class Join implements QueryModifier
{
    /**
     * @var string field
     */
    private $field;

    /**
     * @var string alias
     */
    private $newAlias;
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

        $qb->join(sprintf('%s.%s', $dqlAlias, $this->field), $this->newAlias);
    }
}
