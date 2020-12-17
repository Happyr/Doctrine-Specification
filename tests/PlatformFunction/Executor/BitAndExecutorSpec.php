<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\PlatformFunction\Executor\BitAndExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin BitAndExecutor
 */
final class BitAndExecutorSpec extends ObjectBehavior
{
    public function it_should_be_executable(): void
    {
        $this(1, 2)->shouldBe(0);
        $this(3, 2)->shouldBe(2);
    }
}
