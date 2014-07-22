<?php

namespace Happyr\Doctrine\Specification\Spec;

/**
 * Class OrX
 *
 * @author Tobias Nyholm
 *
 */
class OrX implements LogicExpression
{
    public function getExpression()
    {
        return 'orX';
    }
}