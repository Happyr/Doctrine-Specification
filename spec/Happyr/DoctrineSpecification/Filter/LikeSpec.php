<?php

namespace spec\Happyr\DoctrineSpecification\Spec;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Like;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LikeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('field', 'value', Like::CONTAINS);
    }

    function it_is_a_filter()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Filter\FilterInterface');
    }

    function it_is_a_comparision()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Filter\ComparisonInterface');
    }

    function it_has_field_name()
    {
        $this->getField()->shouldReturn('field');
    }

    function it_has_field_value()
    {
        $this->getValue()->shouldReturn('value');
    }

    function it_has_format()
    {
        $this->getFormat()->shouldReturn(Like::CONTAINS);
    }
}
