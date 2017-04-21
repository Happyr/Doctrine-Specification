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
    const ENDS_WITH = 1;
    const STARTS_WITH = 2;
    const CONTAINS = self::ENDS_WITH | self::STARTS_WITH;

    /**
     * @var int
     */
    private $format;

    /**
     * @param string $field
     * @param string $value
     * @param int $format
     */
    public function __construct($field, $value, $format = self::CONTAINS)
    {
        $this->format = $format;
        parent::__construct($field, $value);
    }

    /**
     * @return int
     */
    public function getFormat()
    {
        return $this->format;
    }
}
