<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace Happyr\DoctrineSpecification\PlatformFunction\Executor;

final class BitOrExecutor
{
    /**
     * @param int $a
     * @param int $b
     *
     * @return int
     */
    public function __invoke(int $a, int $b): int
    {
        return $a | $b;
    }
}
