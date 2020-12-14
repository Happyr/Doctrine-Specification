<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace Happyr\DoctrineSpecification\PlatformFunction\Executor;

final class ModExecutor
{
    /**
     * @param float $a
     * @param float $b
     *
     * @return float
     */
    public function __invoke(float $a, float $b): float
    {
        return fmod($a, $b);
    }
}
