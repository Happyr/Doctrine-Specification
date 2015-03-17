<?php

namespace Happyr\DoctrineSpecification\Logic;

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
     * @param |Happyr\DoctrineSpecification\Filter\Filter|\Happyr\DoctrineSpecification\Query\QueryModifier $child
     */
    public function andX($child)
    {
        $this->append($child);
    }
}
