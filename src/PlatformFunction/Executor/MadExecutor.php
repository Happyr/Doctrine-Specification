<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace Happyr\DoctrineSpecification\PlatformFunction\Executor;

final class MadExecutor
{
    /**
     * @param float ...$arguments
     *
     * @return float
     */
    public function __invoke(...$arguments): float
    {
        [$num1, $num2] = $arguments;

        return fmod($num1, $num2);
    }
}
