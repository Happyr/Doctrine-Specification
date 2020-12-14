<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace Happyr\DoctrineSpecification\PlatformFunction\Executor;

final class DateDiffExecutor
{
    /**
     * @param \DateTimeInterface ...$arguments
     *
     * @return \DateInterval
     */
    public function __invoke(...$arguments): \DateInterval
    {
        return $arguments[0]->diff($arguments[1]);
    }
}
