<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace Happyr\DoctrineSpecification\PlatformFunction\Executor;

final class ConcatExecutor
{
    /**
     * @param string $string1
     * @param string $string2
     *
     * @return string
     */
    public function __invoke(string $string1, string $string2): string
    {
        return $string1.$string2;
    }
}
