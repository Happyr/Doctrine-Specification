<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace Happyr\DoctrineSpecification\PlatformFunction\Executor;

final class AbsExecutor
{
    /**
     * @param mixed $arithmetic_expression
     *
     * @return float|int
     */
    public function __invoke($arithmetic_expression)
    {
        return abs($arithmetic_expression);
    }
}
