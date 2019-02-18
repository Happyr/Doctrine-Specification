<?php

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\QueryBuilder;

class InstanceOfX implements Filter
{
    /**
     * @var null|string dqlAlias
     */
    protected $dqlAlias;

    /**
     * @var string value
     */
    protected $value;

    /**
     * @param string      $value
     * @param string|null $dqlAlias
     */
    public function __construct($value, $dqlAlias = null)
    {
        $this->dqlAlias = $dqlAlias;
        $this->value = $value;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, $dqlAlias)
    {
        if (null !== $this->dqlAlias) {
            $dqlAlias = $this->dqlAlias;
        }

        return sprintf('%s INSTANCE OF %s', $dqlAlias, $this->value);
    }
}
