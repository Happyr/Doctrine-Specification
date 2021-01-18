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

use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\LocateExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin LocateExecutor
 */
final class LocateExecutorSpec extends ObjectBehavior
{
    public function it_should_not_found_string(): void
    {
        $this('foo', 'bar')->shouldBe(0);
        $this('foo', 'bar', 1)->shouldBe(0);
    }

    public function it_should_not_found_string_with_offset(): void
    {
        $this('foo', 'foobar', 3)->shouldBe(0);
    }

    public function it_should_found_string(): void
    {
        $this('foo', 'barfoobaz')->shouldBe(4);
    }

    public function it_should_found_string_with_offset(): void
    {
        $this('foo', 'barfoobaz', 3)->shouldBe(4);
    }
}
