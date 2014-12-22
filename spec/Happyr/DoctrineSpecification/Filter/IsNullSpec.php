<?php

namespace spec\Happyr\DoctrineSpecification\Filter;

use Happyr\DoctrineSpecification\Filter\IsNull;
use PhpSpec\ObjectBehavior;

/**
 * @mixin IsNull
 */
class IsNullSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('field');
    }

    function it_is_a_filter()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Filter\FilterInterface');
    }

    function it_has_field_name()
    {
        $this->getField()->shouldReturn('field');
    }
}
