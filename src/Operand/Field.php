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
     * @param string $fieldName
     */
    public function __construct($fieldName)
    {
        $this->fieldName = $fieldName;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, $dqlAlias)
    {
        return sprintf('%s.%s', $dqlAlias, $this->fieldName);
    }
}
