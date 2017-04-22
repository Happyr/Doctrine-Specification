<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Exception;

class InvalidArgumentException extends \InvalidArgumentException
{
    /**
     * @param array $supported_formats
     * @param string $format
     *
     * @return self
     */
    public static function invalidLikeFormat(array $supported_formats, $format)
    {
        return new self(sprintf(
            '"%s" is not a valid format. Valid format are: "%s"',
            $format,
            implode(', ', $supported_formats)
        ));
    }

    /**
     * @param array $supported_types
     * @param string $type
     *
     * @return self
     */
    public static function invalidJoinConditionType(array $supported_types, $type)
    {
        return new self(sprintf(
            '"%s" is not a valid condition type. Valid condition type are: "%s"',
            $type,
            implode(', ', $supported_types)
        ));
    }

    /**
     * @return self
     */
    public static function joinRequireConditionAndConditionType()
    {
        return new self('Join specification must have a condition and condition type.');
    }

    /**
     * @param array $supported_types
     * @param string $type
     *
     * @return self
     */
    public static function invalidOrderType(array $supported_types, $type)
    {
        return new self(sprintf(
            '"%s" is not a valid order. Valid order are: "%s"',
            $type,
            implode(', ', $supported_types)
        ));
    }
}
