<?php

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\Operand;

class InstanceOfX implements Filter
{
    /**
     * @var string|null
     */
    protected $dqlAlias;

    /**
     * @var Operand|string
     */
    protected $value;

    /**
     * @param Operand|string $value
     * @param string|null    $dqlAlias
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

        $value = ArgumentToOperandConverter::convertValue($this->value);

        return sprintf('%s INSTANCE OF %s', $dqlAlias, $value->transform($qb, $dqlAlias));
    }
}
