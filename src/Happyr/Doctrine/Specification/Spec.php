<?php

namespace Happyr\Doctrine\Specification;

use Happyr\Doctrine\Specification\Spec\AndX;
use Happyr\Doctrine\Specification\Spec\LogicX;

class Spec
{
    public static function andX()
    {
        return new LogicX(new AndX(), func_get_args());
    }
} 
