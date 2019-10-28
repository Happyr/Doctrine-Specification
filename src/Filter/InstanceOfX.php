<?php

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\QueryBuilder;

class InstanceOfX implements Filter
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var string|null
     */
    private $dqlAlias;

    /**
     * @param string      $value
     * @param string|null $dqlAlias
     */
    public function __construct($value, $dqlAlias = null)
    {
        $this->value = $value;
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
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        return sprintf('%s INSTANCE OF %s', $dqlAlias, $this->value);
    }
}
