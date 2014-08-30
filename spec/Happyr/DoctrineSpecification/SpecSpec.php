<?php

namespace spec\Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Spec;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin Spec
 */
class SpecSpec extends ObjectBehavior
{
    function it_creates_and_x_specification()
    {
        $this->andX()->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Logic\LogicX');
    }
}
