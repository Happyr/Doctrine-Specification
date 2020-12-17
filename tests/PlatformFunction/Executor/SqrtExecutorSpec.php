<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\PlatformFunction\Executor\SqrtExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin SqrtExecutor
 */
final class SqrtExecutorSpec extends ObjectBehavior
{
    public function it_should_return_square_root(): void
    {
        $this(9)->shouldBe(3);
    }
}
