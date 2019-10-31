<?php

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\Operand;

class In implements Filter
{
    /**
     * @deprecated This property will be marked as private in 2.0.
     *
     * @var Operand|string
     */
    protected $field;

    /**
     * @deprecated This property will be marked as private in 2.0.
     *
     * @var Operand|mixed
     */
    protected $value;

    /**
     * @deprecated This property will be marked as private in 2.0.
     *
     * @var string|null
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

        $field = ArgumentToOperandConverter::toField($this->field);
        $value = ArgumentToOperandConverter::toValue($this->value);

        return (string) $qb->expr()->in(
            $field->transform($qb, $dqlAlias),
            $value->transform($qb, $dqlAlias)
        );
    }
}
