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
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\AbsExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\BitAndExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\BitOrExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\ConcatExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\CurrentDateExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\CurrentTimeExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\CurrentTimestampExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\DateDiffExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\IdentityExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\LengthExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\LocateExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\LowerExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\ModExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\PlatformFunctionExecutorRegistry;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\SizeExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\SqrtExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\SubstringExecutor;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\UpperExecutor;

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
        'CONCAT' => ConcatExecutor::class,
        'SUBSTRING' => SubstringExecutor::class,
        'LOWER' => LowerExecutor::class,
        'UPPER' => UpperExecutor::class,
        'IDENTITY' => IdentityExecutor::class,
        // Numeric functions
        'LENGTH' => LengthExecutor::class,
        'LOCATE' => LocateExecutor::class,
        'ABS' => AbsExecutor::class,
        'SQRT' => SqrtExecutor::class,
        'MOD' => ModExecutor::class,
        'SIZE' => SizeExecutor::class,
        'DATE_DIFF' => DateDiffExecutor::class,
        'BIT_AND' => BitAndExecutor::class,
        'BIT_OR' => BitOrExecutor::class,
        // Datetime functions
        'CURRENT_DATE' => CurrentDateExecutor::class,
        'CURRENT_TIME' => CurrentTimeExecutor::class,
        'CURRENT_TIMESTAMP' => CurrentTimestampExecutor::class,
    ];

    /**
     * @var PlatformFunctionExecutorRegistry|null
     */
    private static $executorRegistry;

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
     * @param string|null    $context
     *
     * @return mixed
     */
    public function execute($candidate, ?string $context = null)
    {
        $arguments = [];
        foreach (ArgumentToOperandConverter::convert($this->arguments) as $argument) {
            $arguments[] = $argument->execute($candidate, $context);
        }

        return self::getExecutorRegistry()->execute($this->functionName, ...$arguments);
    }

    /**
     * @return PlatformFunctionExecutorRegistry
     */
    public static function getExecutorRegistry(): PlatformFunctionExecutorRegistry
    {
        if (!self::$executorRegistry instanceof PlatformFunctionExecutorRegistry) {
            $instances = [];

            foreach (self::DOCTRINE_FUNCTIONS as $functionName => $class) {
                $instances[$functionName] = new $class();
            }

            self::$executorRegistry = new PlatformFunctionExecutorRegistry($instances);
        }

        return self::$executorRegistry;
    }
}
