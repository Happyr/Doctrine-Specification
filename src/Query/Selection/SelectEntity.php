<?php

namespace Happyr\DoctrineSpecification\Query\Selection;

use Doctrine\ORM\QueryBuilder;

class SelectEntity implements Selection
{
    /**
     * @var string
     */
    private $dqlAlias = '';

    /**
     * @param string $dqlAlias
     */
    public function __construct($dqlAlias)
    {
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, $dqlAlias)
    {
        return $this->dqlAlias;
    }
}
