<?php

namespace tests\Happyr\DoctrineSpecification\Filter;

use Happyr\DoctrineSpecification\Filter\In;
use PhpSpec\ObjectBehavior;

/**
 * @mixin In
 */
class InSpec extends ObjectBehavior
{
    private $field = 'foobar';

    private $value = ['bar', 'baz'];

    public function let()
    {
        $this->beConstructedWith($this->field, $this->value);
    }

    public function it_is_an_expression()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Filter\Filter');
    }

    public function it_should_return_field()
    {
        $this->getField()->shouldReturn($this->field);
    }

    public function it_should_return_value()
    {
        $this->getValue()->shouldReturn($this->value);
    }
}
