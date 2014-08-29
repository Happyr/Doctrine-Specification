<?php

namespace spec\Happyr\Doctrine\Specification;

use Happyr\Doctrine\Specification\Spec;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin Spec
 */
class SpecSpec extends ObjectBehavior
{
    function it_creates_and_x_specification()
    {
        $this->andX()->shouldReturnAnInstanceOf('Happyr\Doctrine\Specification\Logic\LogicX');
    }
}
