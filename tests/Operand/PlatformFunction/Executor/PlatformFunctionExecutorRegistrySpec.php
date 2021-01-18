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

namespace tests\Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\Exception\PlatformFunctionExecutorException;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\PlatformFunctionExecutorRegistry;
use PhpSpec\ObjectBehavior;

/**
 * @mixin PlatformFunctionExecutorRegistry
 */
final class PlatformFunctionExecutorRegistrySpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith([
            'abs' => 'abs',
        ]);
    }

    public function it_should_register_executor(): void
    {
        $executor = function (int $x, int $y): int {
            return $x + $y;
        };

        $this->register('Sum', $executor);
        $this->has('sum')->shouldBe(true);
        $this->has('SUM')->shouldBe(true);
    }

    public function it_should_throw_exception_on_register_exist_executor(): void
    {
        $executor = function ($x) {
            return $x > 0 ? $x : $x * -1;
        };

        $this->shouldThrow(PlatformFunctionExecutorException::class)->during('register', ['abs', $executor]);
    }

    public function it_should_override_executor(): void
    {
        $executor = function ($x) {
            return $x > 0 ? $x : $x * -1;
        };

        $this->override('Abs', $executor);
        $this->has('abs')->shouldBe(true);
        $this->has('ABS')->shouldBe(true);
    }

    public function it_should_throw_exception_on_override_undefined_executor(): void
    {
        $executor = function (int $x, int $y): int {
            return $x + $y;
        };

        $this->shouldThrow(PlatformFunctionExecutorException::class)->during('override', ['sum', $executor]);
    }

    public function it_should_execute(): void
    {
        $this->execute('abs', -5)->shouldBe(5);
        $this->execute('abs', 5)->shouldBe(5);
    }

    public function it_should_execute_custom_executor(): void
    {
        $executor = function (int $x, int $y): int {
            return $x + $y;
        };

        $this->register('Sum', $executor);
        $this->execute('sum', 2, 3)->shouldBe(5);
    }
}
