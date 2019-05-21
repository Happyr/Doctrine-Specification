<?php

namespace Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Query\Selection\Selection;

class Field implements Operand, Selection
{
    /**
     * @var string
     */
    private $fieldName = '';

    /**
     * @var string
     */
    private $dqlAlias;

    /**
     * @param string      $fieldName
     * @param string|null $dqlAlias
     */
    public function __construct($fieldName, $dqlAlias = null)
    {
        $this->fieldName = $fieldName;
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
        if (null !== $this->dqlAlias) {
            $dqlAlias = $this->dqlAlias;
        }

        return sprintf('%s.%s', $dqlAlias, $this->fieldName);
    }
}
