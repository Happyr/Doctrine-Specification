<?php

namespace spec\Happyr\DoctrineSpecification\Logic;

use Happyr\DoctrineSpecification\Logic\LogicX;
use Happyr\DoctrineSpecification\Specification;
use PhpSpec\ObjectBehavior;

/**
 * @mixin LogicX
 */
class LogicXSpec extends ObjectBehavior
{
    const EXPRESSION = 'andX';

    function let(Specification $specificationA, Specification $specificationB)
    {
        $this->beConstructedWith(self::EXPRESSION, array($specificationA, $specificationB));
    }

//    function it_is_a_specification()
//    {
//        $this->shouldHaveType('Happyr\DoctrineSpecification\Specification');
//    }
}
