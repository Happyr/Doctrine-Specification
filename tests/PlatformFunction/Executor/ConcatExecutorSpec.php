<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\PlatformFunction\Executor\ConcatExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin ConcatExecutor
 */
final class ConcatExecutorSpec extends ObjectBehavior
{
    public function it_should_be_executable(): void
    {
        $this('foo', 'bar')->shouldBe('foobar');
    }
}
