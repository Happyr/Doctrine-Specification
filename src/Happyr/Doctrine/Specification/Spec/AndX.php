<?php

namespace Happyr\Doctrine\Specification\Spec;

/**
 * Class AndX
 *
 * @author Tobias Nyholm
 *
 */
class AndX implements LogicExpression
{
    /**
     * @return string
     */
    public function getExpression()
    {
        return 'andX';
    }
}
