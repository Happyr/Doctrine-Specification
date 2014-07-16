<?php

namespace Happyr\Doctrine\Specification\Spec;

/**
 * Class AndX
 *
 * @author Tobias Nyholm
 *
 */
class AndX extends LogicX
{
    protected function getLogicExpression()
    {
        return 'andX';
    }
}