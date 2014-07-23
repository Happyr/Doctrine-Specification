<?php

namespace spec\Happyr\Doctrine\Specification\Spec;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Happyr\Doctrine\Specification\Spec\Comparison;
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
    
    function it_is_a_specification()
    {
        $this->shouldBeAnInstanceOf('Happyr\Doctrine\Specification\Spec\Specification');
    }
    
    function it_returns_comparison_object(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 18)->shouldBeCalled();

        $comparison = $this->match($qb, null);

        $comparison->shouldBeAnInstanceOf('Doctrine\ORM\Query\Expr\Comparison');
        $comparison->getLeftExpr()->shouldReturn('a.age');
        $comparison->getOperator()->shouldReturn(Comparison::GT);
        $comparison->getRightExpr()->shouldReturn(':comparison_10');
    }

    function it_uses_comparison_specific_dql_alias_if_passed(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $this->beConstructedWith(Comparison::GT, 'age', 18, null);

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 18)->shouldBeCalled();

        $this->match($qb, 'x')->getLeftExpr()->shouldReturn('x.age');
    }

    function it_validates_operator()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('__construct', array('==', 'age', 18, null));
    }
}
