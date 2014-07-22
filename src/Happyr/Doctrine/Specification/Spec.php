<?php

namespace Happyr\Doctrine\Specification;

use Happyr\Doctrine\Specification\Spec\AndX;
use Happyr\Doctrine\Specification\Spec\LogicX;
use Happyr\Doctrine\Specification\Spec\OrX;

class Spec
{
    public static function andX()
    {
        return new LogicX(new AndX(), func_get_args());
    }

    public static function orX()
    {
        return new LogicX(new OrX(), func_get_args());
    }

    public static function collection()
    {
        return new LogicX(new AndX(), func_get_args());
    }
} 
