<?php

namespace spec\Happyr\Doctrine\Specification\Spec;

use Happyr\Doctrine\Specification\Spec\AndX;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin AndX
 */
class AndXSpec extends ObjectBehavior
{
    function it_is_a_logic_expression()
    {
        $this->shouldHaveType('Happyr\Doctrine\Specification\Spec\LogicExpression');
    }

    function it_is_and_expression()
    {
        $this->getExpression()->shouldReturn('andX');
    }
}
