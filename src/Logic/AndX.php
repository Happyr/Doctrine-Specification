<?php

namespace Happyr\DoctrineSpecification\Logic;

class AndX extends LogicX
{
    public function __construct()
    {
        parent::__construct(self::AND_X, func_get_args());
    }
}
