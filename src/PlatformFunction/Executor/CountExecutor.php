<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\Exception\OperandNotExecuteException;

final class CountExecutor implements PlatformFunctionExecutor
{
    /**
     * @param mixed ...$arguments
     */
    public function __invoke(...$arguments): void
    {
        throw new OperandNotExecuteException(
            sprintf('Platform function "%s" cannot be executed for a single candidate.', __CLASS__)
        );
    }
}
