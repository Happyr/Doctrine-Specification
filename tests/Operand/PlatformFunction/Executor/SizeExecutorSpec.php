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

use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\SizeExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin SizeExecutor
 */
final class SizeExecutorSpec extends ObjectBehavior
{
    public function it_should_return_array_size(): void
    {
        $this(['foo', 'bar'])->shouldBe(2);
    }
}
