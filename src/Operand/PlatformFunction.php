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
use Happyr\DoctrineSpecification\PlatformFunction\Executor\PlatformFunctionExecutorRegistry;

final class PlatformFunction implements Operand
{
    /**
     * Doctrine internal functions.
     *
     * @see \Doctrine\ORM\Query\Parser
     *
     * @var string[]
     */
    private const DOCTRINE_FUNCTIONS = [
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
     * @var PlatformFunctionExecutorRegistry|null
     */
    private static $executorRegistry = null;

    /**
     * @var string
     */
    private $functionName;

    /**
     * @var mixed[]
     */
    private $arguments;

    /**
     * @param string        $functionName
     * @param Operand|mixed ...$arguments
     */
    public function __construct(string $functionName, ...$arguments)
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
    public function transform(QueryBuilder $qb, string $dqlAlias): string
    {
        if (!in_array(strtolower($this->functionName), self::DOCTRINE_FUNCTIONS, true) &&
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

    /**
     * @param array|object $candidate
     *
     * @return mixed
     */
    public function execute($candidate)
    {
        $arguments = [];
        foreach (ArgumentToOperandConverter::convert($this->arguments) as $argument) {
            $arguments[] = $argument->execute($candidate);
        }

        return self::getExecutorRegistry()->execute($this->functionName, ...$arguments);
    }

    /**
     * @return PlatformFunctionExecutorRegistry
     */
    public static function getExecutorRegistry(): PlatformFunctionExecutorRegistry
    {
        if (null === self::$executorRegistry) {
            self::$executorRegistry = new PlatformFunctionExecutorRegistry([]);
        }

        return self::$executorRegistry;
    }
}
