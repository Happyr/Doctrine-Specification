<?php

namespace Happyr\DoctrineSpecification\Logic;

class AndX extends LogicX
{
    function __construct()
    {
        parent::__construct(self::AND_X, func_get_args());
    }
}
