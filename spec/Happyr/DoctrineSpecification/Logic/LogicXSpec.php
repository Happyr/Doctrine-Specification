<?php

namespace spec\Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Expression;
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

    function it_modifies_all_child_queries(QueryBuilder $queryBuilder, Specification $specificationA, Specification $specificationB)
    {
        $dqlAlias = 'a';

        $specificationA->modify($queryBuilder, $dqlAlias)->shouldBeCalled();
        $specificationB->modify($queryBuilder, $dqlAlias)->shouldBeCalled();

        $this->modify($queryBuilder, $dqlAlias);
    }

    function it_composes_and_child_with_expression(QueryBuilder $qb, Expr $expression, Specification $specificationA, Specification $specificationB, $x, $y)
    {
        $dqlAlias = 'a';

        $specificationA->getExpression($qb, $dqlAlias)->willReturn($x);
        $specificationB->getExpression($qb, $dqlAlias)->willReturn($y);
        $qb->expr()->willReturn($expression);

        $expression->{self::EXPRESSION}($x, $y)->shouldBeCalled();

        $this->getExpression($qb, $dqlAlias);
    }

    /**
     * Make sure you may use Expressions with the Logic
     */
    function it_works_with_expressions(QueryBuilder $qb, Expr $expression, Expression $exprA, Expression $exprB, $x, $y)
    {
        $this->beConstructedWith(self::EXPRESSION, array($exprA, $exprB));

        $dqlAlias = 'a';

        $exprA->getExpression($qb, $dqlAlias)->willReturn($x);
        $exprB->getExpression($qb, $dqlAlias)->willReturn($y);
        $qb->expr()->willReturn($expression);

        $expression->{self::EXPRESSION}($x, $y)->shouldBeCalled();

        $this->getExpression($qb, $dqlAlias);

    }
}
