<?php

namespace Happyr\Doctrine\Specification;

use Happyr\Doctrine\Specification\Spec\AndX;
use Happyr\Doctrine\Specification\Spec\LogicX;
use Happyr\Doctrine\Specification\Spec\OrX;

class Spec
{
    public static function andX()
    {
        return new LogicX(LogicX::AND_X, func_get_args());
    }

    public static function orX()
    {
        return new LogicX(LogicX::OR_X, func_get_args());
    }

    public static function collection()
    {
        return new LogicX(LogicX::AND_X, func_get_args());
    }
} 
