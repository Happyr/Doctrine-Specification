<?php

namespace Happyr\DoctrineSpecification\Logic;

use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;

class OrX extends LogicX
{
    public function __construct()
    {
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
