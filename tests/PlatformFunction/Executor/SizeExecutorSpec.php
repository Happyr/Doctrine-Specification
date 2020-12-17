<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\PlatformFunction\Executor\SizeExecutor;
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
