<?php

namespace spec\Happyr\DoctrineSpecification\Filter;

use Happyr\DoctrineSpecification\Filter\Comparison;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Comparison
 */
class ComparisonSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Comparison::GT, 'age', 18);
    }

    function it_is_an_expression()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Filter\Filter');
    }

    function it_validates_operator()
    {
        $this->shouldThrow('Happyr\DoctrineSpecification\Exception\InvalidArgumentException')->during('__construct', array('==', 'age', 18));
    }
}
