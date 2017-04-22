<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\QueryModifier;

use Happyr\DoctrineSpecification\Filter\Filter;

abstract class AbstractJoin implements QueryModifier
{
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
    private $with;

    /**
     * @param string $field
     * @param string $alias
     * @param Filter|null $with
     */
    public function __construct($field, $alias, Filter $with = null)
    {
        $this->field = $field;
        $this->alias = $alias;
        $this->with = $with;
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
    public function getWith()
    {
        return $this->with;
    }
}
