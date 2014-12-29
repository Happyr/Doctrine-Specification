<?php

namespace spec\Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\Query\Expr;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Logic\Not;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin Not
 */
class NotSpec extends ObjectBehavior
{
    function let(Filter $filterExpr)
    {
        $this->beConstructedWith($filterExpr, null);
    }

//    function it_is_a_specification()
//    {
//        $this->shouldHaveType('Happyr\DoctrineSpecification\Specification');
//    }
}
