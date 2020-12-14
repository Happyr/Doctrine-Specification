<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace Happyr\DoctrineSpecification\PlatformFunction\Executor;

final class BitAndExecutor
{
    /**
     * @param int ...$arguments
     *
     * @return int
     */
    public function __invoke(...$arguments): int
    {
        [$x, $y] = $arguments;

        return $x & $y;
    }
}
