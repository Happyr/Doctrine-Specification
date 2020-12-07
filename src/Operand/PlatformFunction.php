<?php
declare(strict_types=1);

/**
 * This file is part of the Happyr Doctrine Specification package.
 *
 * (c) Tobias Nyholm <tobias@happyr.com>
 *     Kacper Gunia <kacper@gunia.me>
 *     Peter Gribanov <info@peter-gribanov.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;

class PlatformFunction implements Operand
{
    /**
     * Doctrine internal functions.
     *
     * @see \Doctrine\ORM\Query\Parser
     *
     * @var string[]
     */
    private static $doctrineFunctions = [
        // String functions
        'concat',
        'substring',
        'trim',
        'lower',
        'upper',
        'identity',
        // Numeric functions
        'length',
        'locate',
        'abs',
        'sqrt',
        'mod',
        'size',
        'date_diff',
        'bit_and',
        'bit_or',
        // Aggregate functions
        'min',
        'max',
        'avg',
        'sum',
        'count',
        // Datetime functions
        'current_date',
        'current_time',
        'current_timestamp',
        'date_add',
        'date_sub',
    ];

    /**
     * @var string
     */
    private $functionName;

    /**
     * @var mixed[]
     */
    private $arguments;

    /**
     * @param string $functionName
     * @param mixed  ...$arguments
     */
    public function __construct($functionName, ...$arguments)
    {
        $this->functionName = $functionName;
        $this->arguments = $arguments;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, $dqlAlias)
    {
        if (!in_array(strtolower($this->functionName), self::$doctrineFunctions, true) &&
            !$qb->getEntityManager()->getConfiguration()->getCustomStringFunction($this->functionName) &&
            !$qb->getEntityManager()->getConfiguration()->getCustomNumericFunction($this->functionName) &&
            !$qb->getEntityManager()->getConfiguration()->getCustomDatetimeFunction($this->functionName)
        ) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid function name.', $this->functionName));
        }

        $arguments = [];
        foreach (ArgumentToOperandConverter::convert($this->arguments) as $argument) {
            $arguments[] = $argument->transform($qb, $dqlAlias);
        }

        return sprintf('%s(%s)', $this->functionName, implode(', ', $arguments));
    }
}
