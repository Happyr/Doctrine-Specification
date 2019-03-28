<?php

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;
use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\Operand;

class Like implements Filter
{
    const CONTAINS = '%%%s%%';

    const ENDS_WITH = '%%%s';

    const STARTS_WITH = '%s%%';

    /**
     * @var Operand|string
     */
    private $field;

    /**
     * @var Operand|string
     */
    private $value;

    /**
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $dqlAlias;

    /**
     * @param Operand|string $field
     * @param string         $value
     * @param string         $format
     * @param string|null    $dqlAlias
     */
    public function __construct($field, $value, $format = self::CONTAINS, $dqlAlias = null)
    {
        $this->field = $field;
        $this->value = $value;
        $this->format = $format;
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

        $field = $field->transform($qb, $dqlAlias);
        $value = $value->transform($qb, $dqlAlias);
        $value = $this->formatValue($this->format, $value);

        return (string) new DoctrineComparison($field, 'LIKE', $value);
    }

    /**
     * @param string $format
     * @param string $value
     *
     * @return string
     */
    private function formatValue($format, $value)
    {
        return sprintf($format, $value);
    }
}
