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
        $this->add('value');
        $this->getLastName()->shouldReturn('?1');
        $this->add('value2');
        $this->getLastName()->shouldReturn('?2');
    }

    function it_can_hold_parameters()
    {
        $this->hasAny()->shouldReturn(false);
        $this->add('value');
        $this->hasAny()->shouldReturn(true);
    }

    function it_should_be_able_to_reset_itself()
    {
        $this->add('value');
        $this->clearAll();
        $this->hasAny()->shouldReturn(false);
    }

    function it_should_return_values()
    {
        $this->add('value');
        $this->getAll()->shouldReturn([1 => 'value']);
    }
}
