<?php

namespace Happyr\Doctrine\Specification\Spec;

class OrX extends LogicX
{
    function __construct()
    {
        parent::__construct(self::OR_X, func_get_args());
    }
}
