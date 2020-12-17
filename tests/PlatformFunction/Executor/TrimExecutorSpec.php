<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\PlatformFunction\Executor\TrimExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin TrimExecutor
 */
final class TrimExecutorSpec extends ObjectBehavior
{
    public function it_should_trim_value(): void
    {
        $this(' foo ')->shouldBe('foo');
    }
}
