<?php

namespace Happyr\Doctrine\Specification\Spec;

/**
 * Class OrX
 *
 * @author Tobias Nyholm
 *
 */
class OrX extends LogicX
{
    protected function getLogicExpression()
    {
        return 'orX';
    }
}