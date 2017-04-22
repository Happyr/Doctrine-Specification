<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Exception;

use Happyr\DoctrineSpecification\Exception\InvalidArgumentException as BaseInvalidArgumentException;

class InvalidArgumentException extends BaseInvalidArgumentException
{
    /**
     * @param array $supported_operators
     * @param string $operator
     *
     * @return self
     */
    public static function invalidComparisonOperator(array $supported_operators, $operator)
    {
        return new self(sprintf(
            '"%s" is not a valid comparison operator. Valid operators are: "%s"',
            $operator,
            implode(', ', $supported_operators)
        ));
    }
}
