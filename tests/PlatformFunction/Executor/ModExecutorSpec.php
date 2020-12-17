<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\PlatformFunction\Executor\ModExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin ModExecutor
 */
final class ModExecutorSpec extends ObjectBehavior
{
    public function it_should_return_remainder_modulo(): void
    {
        $this(5.7, 1.3)->shouldBe(.5);
    }
}
