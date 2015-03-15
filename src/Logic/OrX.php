<?php

namespace Happyr\DoctrineSpecification\Logic;

class OrX extends LogicX
{
    public function __construct()
    {
        parent::__construct(self::OR_X, func_get_args());
    }
}
