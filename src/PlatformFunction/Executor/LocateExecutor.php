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
     * @param mixed  $needle
     * @param string $haystack
     * @param int    $offset
     *
     * @return int
     */
    public function __invoke($needle, string $haystack, int $offset = 0): int
    {
        $position = strpos($haystack, $needle, $offset);

        // in DQL position is shifted
        return $position === false ? 0 : $position + 1;
    }
}
