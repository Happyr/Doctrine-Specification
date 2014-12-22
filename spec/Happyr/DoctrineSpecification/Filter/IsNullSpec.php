<?php

namespace spec\Happyr\DoctrineSpecification\Filter;

use Happyr\DoctrineSpecification\Filter\IsNull;
use PhpSpec\ObjectBehavior;

/**
 * @mixin IsNull
 */
class IsNullSpec extends ObjectBehavior
{
    private $field='foobar';

    function let()
    {
        $this->beConstructedWith($this->field);
    }

    function it_is_an_expression()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Filter\Filter');
    }
}
