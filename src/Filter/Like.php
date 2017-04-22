<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Filter;

use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;

class Like extends Comparison
{
    const ENDS_WITH = 1;
    const STARTS_WITH = 2;
    const CONTAINS = 3; // self::ENDS_WITH | self::STARTS_WITH

    /**
     * @var int
     */
    private $format;

    /**
     * @var array
     */
    private static $formats = [
        self::ENDS_WITH,
        self::STARTS_WITH,
        self::CONTAINS,
    ];

    /**
     * @param string $field
     * @param string $value
     * @param int    $format
     */
    public function __construct($field, $value, $format = self::CONTAINS)
    {
        if (!in_array($format, self::$formats)) {
            throw new InvalidArgumentException(sprintf(
                '"%s" is not a valid format. Valid format are: "%s"',
                $format,
                implode(', ', self::$formats)
            ));
        }

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
