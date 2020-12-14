<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace Happyr\DoctrineSpecification\PlatformFunction\Executor;

final class SubstringExecutor
{
    /**
     * @param string|int ...$arguments
     *
     * @return false|string
     */
    public function __invoke(...$arguments)
    {
        if (count($arguments) === 2) {
            [$string, $offset] = $arguments;

            return substr($string, $offset);
        }

        [$string, $offset, $length] = $arguments;

        return substr($string, $offset, $length);
    }
}
