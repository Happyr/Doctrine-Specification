<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\PlatformFunction\Executor\SubstringExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin SubstringExecutor
 */
final class SubstringExecutorSpec extends ObjectBehavior
{
    public function it_should_substring_value(): void
    {
        $this('foo bar', 0)->shouldBe('foo bar');
        $this('foo bar', 4)->shouldBe('bar');
        $this('foo bar', -3)->shouldBe('bar');
        $this('foo bar', 0, 3)->shouldBe('foo');
        $this('foo bar', 0, -4)->shouldBe('foo');
    }
}
