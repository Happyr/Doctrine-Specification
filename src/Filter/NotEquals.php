<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Filter;

class NotEquals extends Comparison
{
    /**
     * @param string $field
     * @param string $value
     */
    public function __construct($field, $value)
    {
        parent::__construct(self::NEQ, $field, $value);
    }
}
