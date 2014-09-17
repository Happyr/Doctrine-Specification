<?php

namespace spec\Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Logic\Not;
use Happyr\DoctrineSpecification\Specification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin Not
 */
class NotSpec extends ObjectBehavior
{
    function let(Specification $spec)
    {
        $this->beConstructedWith($spec, null);
    }

    /**
     * calls parent
     */
    function it_calls_parent_match(QueryBuilder $qb, Expr $expr, Specification $spec)
    {
        $dqlAlias = 'a';
        $expression = 'expression';
        $parentExpression = 'foobar';

        $qb->expr()->willReturn($expr);
        $spec->getExpression($qb, $dqlAlias)->willReturn($parentExpression);

        $expr->not($parentExpression)->willReturn($expression);

        $this->getExpression($qb, $dqlAlias)->shouldReturn($expression);
    }

    /**
     * modifies parent query
     */
    function it_modifies_parent_query(QueryBuilder $qb, Specification $spec)
    {
        $spec->modify($qb, 'a')->shouldBeCalled();
        $this->modify($qb, 'a');
    }
}
