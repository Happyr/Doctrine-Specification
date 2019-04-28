<?php

namespace Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;

class BitNot implements Operand
{
    /**
     * @var Operand|string
     */
    private $field;

    /**
     * @param Operand|string $field
     */
    public function __construct($field)
    {
        $this->field = $field;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, $dqlAlias)
    {
        $field = ArgumentToOperandConverter::toField($this->field);

        $field = $field->transform($qb, $dqlAlias);

        return sprintf('(~ %s)', $field);
    }
}
