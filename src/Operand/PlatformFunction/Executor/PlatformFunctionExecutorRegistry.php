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

namespace Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\Exception\PlatformFunctionExecutorException;

final class PlatformFunctionExecutorRegistry
{
    /**
     * @var callable[]
     * @phpstan-var array<string, callable>
     */
    private $executors;

    /**
     * @param callable[] $executors
     * @phpstan-param array<string, callable> $executors
     */
    public function __construct(array $executors)
    {
        foreach ($executors as $functionName => $executor) {
            $this->register($functionName, $executor);
        }
    }

    /**
     * @param string $functionName
     * @param mixed  ...$arguments
     *
     * @throw PlatformFunctionExecutorException
     *
     * @return mixed
     */
    public function execute(string $functionName, ...$arguments)
    {
        $functionName = strtoupper($functionName);

        if (!isset($this->executors[$functionName])) {
            throw new PlatformFunctionExecutorException(
                sprintf('Unknown platform function executor "%s" requested.', $functionName)
            );
        }

        return $this->executors[$functionName](...$arguments);
    }

    /**
     * @param string $functionName
     *
     * @return bool
     */
    public function has(string $functionName): bool
    {
        return isset($this->executors[strtoupper($functionName)]);
    }

    /**
     * @param string   $functionName
     * @param callable $executor
     *
     * @throw PlatformFunctionExecutorException
     */
    public function register(string $functionName, callable $executor): void
    {
        $functionName = strtoupper($functionName);

        if (isset($this->executors[$functionName])) {
            throw new PlatformFunctionExecutorException(
                sprintf('Platform function executor "%s" already exists.', $functionName)
            );
        }

        $this->executors[$functionName] = $executor;
    }

    /**
     * @param string   $functionName
     * @param callable $executor
     *
     * @throw PlatformFunctionExecutorException
     */
    public function override(string $functionName, callable $executor): void
    {
        $functionName = strtoupper($functionName);

        if (!isset($this->executors[$functionName])) {
            throw new PlatformFunctionExecutorException(
                sprintf('Platform function executor to be overwritten "%s" does not exist.', $functionName)
            );
        }

        $this->executors[$functionName] = $executor;
    }
}
