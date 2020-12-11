<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace Happyr\DoctrineSpecification\PlatformFunction\Executor;

final class SubstringExecutor implements PlatformFunctionExecutor
{
    /**
     * @param string|int ...$arguments
     *
     * @return false|string
     */
    public function __invoke(...$arguments)
    {
        return substr(...$arguments);
    }
}
