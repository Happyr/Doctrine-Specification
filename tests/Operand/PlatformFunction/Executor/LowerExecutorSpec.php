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

use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\LowerExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin LowerExecutor
 */
final class LowerExecutorSpec extends ObjectBehavior
{
    public function it_should_return_value_in_lower_case(): void
    {
        $this('FoO bAr')->shouldBe('foo bar');
    }
}
