<?php
declare(strict_types=1);

/**
 * This file is part of the Happyr Doctrine Specification package.
 *
 * (c) Tobias Nyholm <tobias@happyr.com>
 *     Kacper Gunia <kacper@gunia.me>
 *     Peter Gribanov <info@peter-gribanov.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\Operand;

/**
 * Comparison class.
 *
 * This is used when you need to compare two values
 */
abstract class Comparison implements Filter
{
    const EQ = '=';

    const NEQ = '<>';

    const LT = '<';

    const LTE = '<=';

    const GT = '>';

    const GTE = '>=';

    /**
     * @deprecated This property will be marked as private in 2.0.
     *
     * @var Operand|string
     */
    protected $field;

    /**
     * @deprecated This property will be marked as private in 2.0.
     *
     * @var Operand|string
     */
    protected $value;

    /**
     * @deprecated This property will be marked as private in 2.0.
     *
     * @var string|null
     */
    protected $dqlAlias;

    /**
     * @var array
     */
    private static $operators = [
        self::EQ, self::NEQ,
        self::LT, self::LTE,
        self::GT, self::GTE,
    ];

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
