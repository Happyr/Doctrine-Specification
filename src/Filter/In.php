<?php

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\Operand;

class In implements Filter
{
    /**
     * @var Operand|string
     */
    protected $field;

    /**
     * @var Operand|mixed
     */
    protected $value;

    /**
     * @var string
     */
    protected $dqlAlias;

    /**
     * Make sure the $field has a value equals to $value.
     *
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     */
    public function __construct($field, $value, $dqlAlias = null)
    {
        $this->field = $field;
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
        if (null !== $this->dqlAlias) {
            $dqlAlias = $this->dqlAlias;
        }

        $field = ArgumentToOperandConverter::convertField($this->field);
        $value = ArgumentToOperandConverter::convertValue($this->value);

        return (string) $qb->expr()->in(
            $field->transform($qb, $dqlAlias),
            $value->transform($qb, $dqlAlias)
        );
    }
}
