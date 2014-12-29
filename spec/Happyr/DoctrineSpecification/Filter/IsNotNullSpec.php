<?php

namespace spec\Happyr\DoctrineSpecification\Filter;

use Happyr\DoctrineSpecification\Filter\IsNotNull;
use PhpSpec\ObjectBehavior;

/**
 * @mixin IsNotNull
 */
class IsNotNullSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('field');
    }

    function it_is_a_filter()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Filter\Base\FilterInterface');
    }

    function it_has_field_name()
    {
        $this->getField()->shouldReturn('field');
    }
}
