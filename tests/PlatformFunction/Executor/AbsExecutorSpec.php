<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\PlatformFunction\Executor\AbsExecutor;
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
