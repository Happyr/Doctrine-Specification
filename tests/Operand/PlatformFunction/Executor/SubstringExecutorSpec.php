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

use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\SubstringExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin SubstringExecutor
 */
final class SubstringExecutorSpec extends ObjectBehavior
{
    public function it_should_substring_value(): void
    {
        $this('foo bar', 0)->shouldBe('foo bar');
        $this('foo bar', 4)->shouldBe('bar');
        $this('foo bar', -3)->shouldBe('bar');
        $this('foo bar', 0, 3)->shouldBe('foo');
        $this('foo bar', 0, -4)->shouldBe('foo');
    }
}
