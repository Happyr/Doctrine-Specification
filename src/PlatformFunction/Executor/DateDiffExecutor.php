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
     * @param \DateTimeInterface $date1
     * @param \DateTimeInterface $date2
     *
     * @return \DateInterval
     */
    public function __invoke(\DateTimeInterface $date1, \DateTimeInterface $date2): \DateInterval
    {
        return $date1->diff($date2);
    }
}
