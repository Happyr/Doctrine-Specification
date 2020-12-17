<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\PlatformFunction\Executor\LowerExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin LowerExecutor
 */
final class LowerExecutorSpec extends ObjectBehavior
{
    public function it_should_return_value_in_lower_case(): void
    {
        $this('FoO bAr')->shouldBe('foo bar');
    }
}
