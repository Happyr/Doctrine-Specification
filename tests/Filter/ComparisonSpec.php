<?php

namespace tests\Happyr\DoctrineSpecification\Filter;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Comparison;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin Comparison
 */
class ComparisonSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Comparison::GT, 'age', 18, 'a');
    }

    function it_is_an_expression()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Filter\Filter');
    }
    
    function it_returns_comparison_object(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 18)->shouldBeCalled();

        $comparison = $this->getFilter($qb, null);

        $comparison->shouldReturn('a.age > :comparison_10');
    }

    function it_uses_comparison_specific_dql_alias_if_passed(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $this->beConstructedWith(Comparison::GT, 'age', 18, null);

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 18)->shouldBeCalled();

        $this->getFilter($qb, 'x')->shouldReturn('x.age > :comparison_10');
    }

    function it_validates_operator()
    {
        $this->shouldThrow('Happyr\DoctrineSpecification\Exception\InvalidArgumentException')->during('__construct', array('==', 'age', 18, null));
    }
}
