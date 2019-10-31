<?php

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

class AndX extends LogicX
{
    public function __construct()
    {
        parent::__construct(self::AND_X, func_get_args());
    }

    /**
     * Append an other specification with a logic AND.
     *
     * <code>
     * $spec = Spec::andX(A, B);
     * $spec->andX(C);
     *
     * // We be the same as
     * $spec = Spec::andX(A, B, C);
     * </code>
     *
     * @param Filter|QueryModifier $child
     */
    public function andX($child)
    {
        $this->append($child);
    }
}
