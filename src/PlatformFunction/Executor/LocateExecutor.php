<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace Happyr\DoctrineSpecification\PlatformFunction\Executor;

final class LocateExecutor implements PlatformFunctionExecutor
{
    /**
     * @param mixed ...$arguments
     *
     * @return false|int
     */
    public function __invoke(...$arguments)
    {
        // change order of needle and haystack arguments
        [$arguments[1], $arguments[0]] = [$arguments[0], $arguments[1]];

        $position = strpos(...$arguments);

        // in DQL position is shifted
        return $position === false ? 0 : $position + 1;
    }
}
