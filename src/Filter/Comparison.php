<?php

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\Operand;

/**
 * Comparison class.
 *
 * This is used when you need to compare two values
 */
class Comparison implements Filter
{
    const EQ = '=';

    const NEQ = '<>';

    const LT = '<';

    const LTE = '<=';

    const GT = '>';

    const GTE = '>=';

    /**
     * @var Operand|string
     */
    protected $field;

    /**
     * @var Operand|string
     */
    protected $value;

    /**
     * @var string|null
     */
    protected $dqlAlias;

    /**
     * @var array
     */
    private static $operators = array(
        self::EQ, self::NEQ,
        self::LT, self::LTE,
        self::GT, self::GTE,
    );

    /**
     * @var string
     */
    private $operator;

    /**
     * Make sure the $field has a value equals to $value.
     *
     * @param string         $operator
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @throws InvalidArgumentException
     */
    public function __construct($operator, $field, $value, $dqlAlias = null)
    {
        if (!in_array($operator, self::$operators, true)) {
            throw new InvalidArgumentException(sprintf(
                '"%s" is not a valid comparison operator. Valid operators are: "%s"',
                $operator,
                implode(', ', self::$operators)
            ));
        }

        $this->operator = $operator;
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

        return (string) new DoctrineComparison(
            $field->transform($qb, $dqlAlias),
            $this->operator,
            $value->transform($qb, $dqlAlias)
        );
    }
}
