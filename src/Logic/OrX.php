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

namespace Happyr\DoctrineSpecification\Logic;

use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;

class OrX extends LogicX
{
    public function __construct()
    {
        // NEXT_MAJOR: use variable-length argument lists (...$children)
        parent::__construct(self::OR_X, func_get_args());
    }

    /**
     * Append an other specification with a logic OR.
     *
     * <code>
     * $spec = Spec::orX(A, B);
     * $spec->orX(C);
     *
     * // We be the same as
     * $spec = Spec::orX(A, B, C);
     * </code>
     *
     * @param Filter|QueryModifier $child
     */
    public function orX($child)
    {
        $this->append($child);
    }
}
