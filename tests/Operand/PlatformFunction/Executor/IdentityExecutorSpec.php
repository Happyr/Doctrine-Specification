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

use Happyr\DoctrineSpecification\Exception\OperandNotExecuteException;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\IdentityExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin IdentityExecutor
 */
final class IdentityExecutorSpec extends ObjectBehavior
{
    public function it_should_throw_exception_on_execute(): void
    {
        $this->shouldThrow(OperandNotExecuteException::class)->during('__invoke');
    }
}
