<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace Happyr\DoctrineSpecification\PlatformFunction\Executor;

final class LocateExecutor
{
    /**
     * @param mixed ...$arguments
     *
     * @return false|int
     */
    public function __invoke(...$arguments)
    {
        if (count($arguments) === 2) {
            [$needle, $haystack] = $arguments;

            $position = strpos($haystack, $needle);
        } else {
            [$needle, $haystack, $offset] = $arguments;

            $position = strpos($haystack, $needle, $offset);
        }

        // in DQL position is shifted
        return $position === false ? 0 : $position + 1;
    }
}
