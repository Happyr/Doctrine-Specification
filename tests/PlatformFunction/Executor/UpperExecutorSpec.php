<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\PlatformFunction\Executor\UpperExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin UpperExecutor
 */
final class UpperExecutorSpec extends ObjectBehavior
{
    public function it_should_return_value_in_upper_case(): void
    {
        $this('fOo BaR')->shouldBe('FOO BAR');
    }
}
