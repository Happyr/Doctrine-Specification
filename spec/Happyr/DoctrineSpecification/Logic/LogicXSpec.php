<?php

namespace spec\Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Logic\LogicX;
use Happyr\DoctrineSpecification\Specification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin LogicX
 */
class LogicXSpec extends ObjectBehavior
{
    const EXPRESSION = 'andX';

    function let(Specification $specificationA, Specification $specificationB)
    {
        $this->beConstructedWith(self::EXPRESSION, array($specificationA, $specificationB));
    }

    function it_is_a_specification()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Specification');
    }

    function it_modifies_all_child_queries(AbstractQuery $query, Specification $specificationA, Specification $specificationB)
    {
        $specificationA->modifyQuery($query)->shouldBeCalled();
        $specificationB->modifyQuery($query)->shouldBeCalled();

        $this->modifyQuery($query);
    }

    function it_composes_and_child_with_expression(QueryBuilder $qb, Expr $expression, Specification $specificationA, Specification $specificationB, $x, $y)
    {
        $dqlAlias = 'a';

        $specificationA->match($qb, $dqlAlias)->willReturn($x);
        $specificationB->match($qb, $dqlAlias)->willReturn($y);
        $qb->expr()->willReturn($expression);

        $expression->{self::EXPRESSION}($x, $y)->shouldBeCalled();

        $this->match($qb, $dqlAlias);
    }
}
