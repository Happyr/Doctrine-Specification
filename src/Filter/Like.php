<?php

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\LikePattern;
use Happyr\DoctrineSpecification\Operand\Operand;

class Like implements Filter
{
    const CONTAINS = LikePattern::CONTAINS;

    const ENDS_WITH = LikePattern::ENDS_WITH;

    const STARTS_WITH = LikePattern::STARTS_WITH;

    /**
     * @var Operand|string
     */
    private $field;

    /**
     * @var LikePattern
     */
    private $value;

    /**
     * @var string|null
     */
    private $dqlAlias;

    /**
     * @param Operand|string     $field
     * @param LikePattern|string $value
     * @param string             $format
     * @param string|null        $dqlAlias
     */
    public function __construct($field, $value, $format = LikePattern::CONTAINS, $dqlAlias = null)
    {
        if (!($value instanceof LikePattern)) {
            $value = new LikePattern($value, $format);
        }
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

        $field = $field->transform($qb, $dqlAlias);
        $value = $this->value->transform($qb, $dqlAlias);

        return (string) new DoctrineComparison($field, 'LIKE', $value);
    }
}
