<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Filter;

/**
 * Comparison class.
 *
 * This is used when you need to compare two values
 */
abstract class Comparison implements Filter
{
    /**
     * @var string field
     */
    private $field;

    /**
     * @var string value
     */
    private $value;

    /**
     * Make sure the $field has a value equals to $value.
     *
     * @param string $field
     * @param string $value
     */
    public function __construct($field, $value)
    {
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
}
