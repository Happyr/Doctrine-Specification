<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\PlatformFunction\Executor\LengthExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin LengthExecutor
 */
final class LengthExecutorSpec extends ObjectBehavior
{
    public function it_should_return_string_length(): void
    {
        $this('foo')->shouldBe(3);
    }
}
