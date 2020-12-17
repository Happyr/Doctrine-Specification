<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\PlatformFunction\Executor\LocateExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin LocateExecutor
 */
final class LocateExecutorSpec extends ObjectBehavior
{
    public function it_should_not_found_string(): void
    {
        $this('foo', 'bar')->shouldBe(0);
        $this('foo', 'bar', 1)->shouldBe(0);
    }

    public function it_should_not_found_string_with_offset(): void
    {
        $this('foo', 'foobar', 3)->shouldBe(0);
    }

    public function it_should_found_string(): void
    {
        $this('foo', 'barfoobaz')->shouldBe(4);
    }

    public function it_should_found_string_with_offset(): void
    {
        $this('foo', 'barfoobaz', 3)->shouldBe(4);
    }
}
