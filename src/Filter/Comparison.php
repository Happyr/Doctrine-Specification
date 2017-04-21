<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Filter;

use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;

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
    const LIKE = 'LIKE';

    /**
     * @var string field
     */
    private $field;

    /**
     * @var string value
     */
    private $value;

    /**
     * @var array
     */
    private static $operators = [
        self::EQ,
        self::NEQ,
        self::LT,
        self::LTE,
        self::GT,
        self::GTE,
        self::LIKE,
    ];

    /**
     * @var string
     */
    private $operator;

    /**
     * Make sure the $field has a value equals to $value.
     *
     * @param string $operator
     * @param string $field
     * @param string $value
     *
     * @throws InvalidArgumentException
     */
    public function __construct($operator, $field, $value)
    {
        if (!in_array($operator, self::$operators)) {
            throw new InvalidArgumentException(sprintf(
                '"%s" is not a valid comparison operator. Valid operators are: "%s"',
                $operator,
                implode(', ', self::$operators)
            ));
        }

        $this->operator = $operator;
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }
}
