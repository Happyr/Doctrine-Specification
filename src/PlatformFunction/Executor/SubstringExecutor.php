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
     * @param string   $string
     * @param int      $offset
     * @param int|null $length
     *
     * @return false|string
     */
    public function __invoke(string $string, int $offset, ?int $length = null)
    {
        if (null === $length) {
            return substr($string, $offset);
        }

        return substr($string, $offset, $length);
    }
}
