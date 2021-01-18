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

use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\AbsExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin AbsExecutor
 */
final class AbsExecutorSpec extends ObjectBehavior
{
    public function it_should_return_absolute_value(): void
    {
        $this(-5)->shouldBe(5);
        $this(5)->shouldBe(5);
    }
}
