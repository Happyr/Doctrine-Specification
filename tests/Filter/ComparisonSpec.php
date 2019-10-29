<?php

namespace tests\Happyr\DoctrineSpecification\Filter;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Filter\Comparison;
use Happyr\DoctrineSpecification\Filter\Filter;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Comparison
 */
class ComparisonSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(Comparison::GT, 'age', 18, 'a');
    }

    public function it_is_an_expression()
    {
        $this->shouldBeAnInstanceOf(Filter::class);
    }

    public function it_returns_comparison_object(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 18, null)->shouldBeCalled();

        $comparison = $this->getFilter($qb, null);

        $comparison->shouldReturn('a.age > :comparison_10');
    }

    public function it_uses_comparison_specific_dql_alias_if_passed(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $this->beConstructedWith(Comparison::GT, 'age', 18, null);

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 18, null)->shouldBeCalled();

        $this->getFilter($qb, 'x')->shouldReturn('x.age > :comparison_10');
    }

    public function it_validates_operator()
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ['==', 'age', 18, null]);
    }

    public function it_not_support_like_operator()
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ['like', 'name', 'Tobias%', null]);
    }
}
