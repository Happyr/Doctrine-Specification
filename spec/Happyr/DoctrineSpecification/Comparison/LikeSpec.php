<?php

namespace spec\Happyr\DoctrineSpecification\Spec;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Happyr\DoctrineSpecification\Comparison\Comparison;

class LikeSpec extends ObjectBehavior
{
    private $field = "foo";

    private $value = "bar";

    public function let()
    {
        $this->beConstructedWith($this->field, $this->value, Like::CONTAINS, "dqlAlias");
    }


    public function it_is_a_specification()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Specification');
    }

    public function it_surrounds_with_wildcards_when_using_contains(QueryBuilder $qb, ArrayCollection $parameters, Expr $expr)
    {
        $this->beConstructedWith($this->field, $this->value, Like::CONTAINS, "dqlAlias");
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(1);

        $qb->setParameter("comparison_1", "%bar%")->shouldBeCalled();

        $this->match($qb, null);
    }

    public function it_starts_with_wildcard_when_using_ends_with(QueryBuilder $qb, ArrayCollection $parameters, Expr $expr)
    {
        $this->beConstructedWith($this->field, $this->value, Like::ENDS_WITH, "dqlAlias");
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(1);

        $qb->setParameter("comparison_1", "%bar")->shouldBeCalled();

        $this->match($qb, null);
    }

    public function it_ends_with_wildcard_when_using_starts_with(QueryBuilder $qb, ArrayCollection $parameters, Expr $expr)
    {
        $this->beConstructedWith($this->field, $this->value, Like::STARTS_WITH, "dqlAlias");
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(1);

        $qb->setParameter("comparison_1", "bar%")->shouldBeCalled();

        $this->match($qb, null);
    }
} 