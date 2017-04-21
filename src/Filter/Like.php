<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Filter;

class Like extends Comparison
{
    const CONTAINS = '%%%s%%';
    const ENDS_WITH = '%%%s';
    const STARTS_WITH = '%s%%';

    /**
     * @param string $field
     * @param string $value
     * @param string $format
     */
    public function __construct($field, $value, $format = self::CONTAINS)
    {
        $formattedValue = $this->formatValue($format, $value);
        parent::__construct($field, $formattedValue);
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
