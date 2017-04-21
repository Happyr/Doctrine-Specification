<?php

namespace tests\Happyr\DoctrineSpecification\Filter;

use Happyr\DoctrineSpecification\Filter\IsNotNull;
use PhpSpec\ObjectBehavior;

/**
 * @mixin IsNotNull
 */
class IsNotNullSpec extends ObjectBehavior
{
    private $field = 'foobar';

    public function let()
    {
        $this->beConstructedWith($this->field);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Filter\IsNotNull');
    }

    public function it_is_an_expression()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Filter\Filter');
    }

    public function it_should_return_field()
    {
        $this->getField()->shouldReturn($this->field);
    }
}
