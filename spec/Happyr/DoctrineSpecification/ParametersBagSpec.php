<?php


namespace spec\Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\ParametersBag;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ParametersBagSpec
 * @mixin ParametersBag
 */
class ParametersBagSpec extends ObjectBehavior
{
    function it_keep_parameters()
    {
        $this->add('value')->shouldReturn('?1');
        $this->add('value2')->shouldReturn('?2');
    }

    function it_can_hold_parameters()
    {
        $this->has()->shouldReturn(false);
        $this->add('value');
        $this->has()->shouldReturn(true);
    }

    function it_should_be_able_to_reset_itself()
    {
        $this->add('value');
        $this->clear();
        $this->has()->shouldReturn(false);
    }

    function it_should_return_values()
    {
        $this->add('value');
        $this->get()->shouldReturn([1 => 'value']);
    }
}
