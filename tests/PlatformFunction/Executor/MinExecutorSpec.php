<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\Exception\OperandNotExecuteException;
use Happyr\DoctrineSpecification\PlatformFunction\Executor\MinExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin MinExecutor
 */
final class MinExecutorSpec extends ObjectBehavior
{
    public function it_should_throw_exception_on_execute(): void
    {
        $this->shouldThrow(OperandNotExecuteException::class)->during('__invoke');
    }
}
