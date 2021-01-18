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

use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\PlatformFunction\Executor;
use Happyr\DoctrineSpecification\PlatformFunction\Executor\PlatformFunctionExecutorRegistry;

final class PlatformFunction implements Operand
{
    /**
     * Doctrine internal functions.
     *
     * @see Parser
     *
     * @var string[]
     */
    private const DOCTRINE_FUNCTIONS = [
        // String functions
        'CONCAT' => Executor\ConcatExecutor::class,
        'SUBSTRING' => Executor\SubstringExecutor::class,
        'TRIM' => Executor\TrimExecutor::class,
        'LOWER' => Executor\LowerExecutor::class,
        'UPPER' => Executor\UpperExecutor::class,
        'IDENTITY' => Executor\IdentityExecutor::class,
        // Numeric functions
        'LENGTH' => Executor\LengthExecutor::class,
        'LOCATE' => Executor\LocateExecutor::class,
        'ABS' => Executor\AbsExecutor::class,
        'SQRT' => Executor\SqrtExecutor::class,
        'MOD' => Executor\ModExecutor::class,
        'SIZE' => Executor\SizeExecutor::class,
        'DATE_DIFF' => Executor\DateDiffExecutor::class,
        'BIT_AND' => Executor\BitAndExecutor::class,
        'BIT_OR' => Executor\BitOrExecutor::class,
        // Aggregate functions
        'MIN' => Executor\MinExecutor::class,
        'MAX' => Executor\MaxExecutor::class,
        'AVG' => Executor\AvgExecutor::class,
        'SUM' => Executor\SumExecutor::class,
        'COUNT' => Executor\CountExecutor::class,
        // Datetime functions
        'CURRENT_DATE' => Executor\CurrentDateExecutor::class,
        'CURRENT_TIME' => Executor\CurrentTimeExecutor::class,
        'CURRENT_TIMESTAMP' => Executor\CurrentTimestampExecutor::class,
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
     * @param string       $context
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, string $context): string
    {
        if (!isset(self::DOCTRINE_FUNCTIONS[strtoupper($this->functionName)]) &&
            !$qb->getEntityManager()->getConfiguration()->getCustomStringFunction($this->functionName) &&
            !$qb->getEntityManager()->getConfiguration()->getCustomNumericFunction($this->functionName) &&
            !$qb->getEntityManager()->getConfiguration()->getCustomDatetimeFunction($this->functionName)
        ) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid function name.', $this->functionName));
        }

        $arguments = [];
        foreach (ArgumentToOperandConverter::convert($this->arguments) as $argument) {
            $arguments[] = $argument->transform($qb, $context);
        }

        return sprintf('%s(%s)', $this->functionName, implode(', ', $arguments));
    }

    /**
     * @param mixed[]|object $candidate
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
            $instances = [];

            foreach (self::DOCTRINE_FUNCTIONS as $functionName => $class) {
                $instances[$functionName] = new $class();
            }

            self::$executorRegistry = new PlatformFunctionExecutorRegistry($instances);
        }

        return self::$executorRegistry;
    }
}
