<?php

namespace tests\Happyr\DoctrineSpecification\Filter;

use Happyr\DoctrineSpecification\Filter\Like;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Like
 */
class LikeSpec extends ObjectBehavior
{
    private $field = 'foo';

    private $value = 'bar';

    private $format = Like::CONTAINS;

    public function let()
    {
        $this->beConstructedWith($this->field, $this->value, $this->format);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Filter\Like');
    }

    public function it_is_a_specification()
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

    public function it_should_return_format()
    {
        $this->getFormat()->shouldReturn($this->format);
    }

    public function it_should_return_format_ends_with()
    {
        $this->beConstructedWith($this->field, $this->value, Like::ENDS_WITH);
        $this->getFormat()->shouldReturn(Like::ENDS_WITH);
    }

    public function it_should_return_format_starts_with()
    {
        $this->beConstructedWith($this->field, $this->value, Like::STARTS_WITH);
        $this->getFormat()->shouldReturn(Like::STARTS_WITH);
    }
}
