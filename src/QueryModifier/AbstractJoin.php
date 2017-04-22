<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\QueryModifier;

use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Filter\Filter;

abstract class AbstractJoin implements QueryModifier
{
    const ON = 'ON';
    const WITH = 'WITH';

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var Filter|null
     */
    private $condition;

    /**
     * @var int|null
     */
    private $conditionType;

    /**
     * @var array
     */
    private static $conditionTypes = [
        self::ON,
        self::WITH,
    ];

    /**
     * @param string      $field
     * @param string      $alias
     * @param int|null    $conditionType
     * @param Filter|null $condition
     */
    public function __construct($field, $alias, $conditionType = null, Filter $condition = null)
    {
        if ($conditionType && !in_array($conditionType, self::$conditionTypes)) {
            throw InvalidArgumentException::invalidJoinConditionType(self::$conditionTypes, $conditionType);
        }

        if ((!$conditionType && $condition) || ($conditionType && !$condition)) {
            throw InvalidArgumentException::joinRequireConditionAndConditionType();
        }

        $this->field = $field;
        $this->alias = $alias;
        $this->condition = $condition;
        $this->conditionType = $conditionType;
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
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return Filter|null
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @return int|null
     */
    public function getConditionType()
    {
        return $this->conditionType;
    }
}
