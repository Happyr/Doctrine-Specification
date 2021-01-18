<?php
declare(strict_types=1);

/**
 * This file is part of the Happyr Doctrine Specification package.
 *
 * (c) Tobias Nyholm <tobias@happyr.com>
 *     Kacper Gunia <kacper@gunia.me>
 *     Peter Gribanov <info@peter-gribanov.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\Exception\OperandNotExecuteException;

final class IdentityExecutor
{
    /**
     * @throw OperandNotExecuteException
     */
    public function __invoke(): void
    {
        throw new OperandNotExecuteException(
            sprintf('Platform function "%s" cannot be executed for a single candidate.', __CLASS__)
        );
    }
}
