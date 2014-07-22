<?php

namespace Happyr\Doctrine\Specification\Spec;

class AndX extends LogicX
{
    function __construct()
    {
        parent::__construct(self::AND_X, func_get_args());
    }
}
