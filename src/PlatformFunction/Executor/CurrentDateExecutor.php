<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace Happyr\DoctrineSpecification\PlatformFunction\Executor;

final class CurrentDateExecutor
{
    /**
     * @return \DateTimeImmutable
     */
    public function __invoke(): \DateTimeImmutable
    {
        return (new \DateTimeImmutable())->setTime(0, 0);
    }
}
