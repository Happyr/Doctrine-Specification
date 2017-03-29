<?php

namespace tests\Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Logic\Not;
use Happyr\DoctrineSpecification\Specification\Specification;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Not
 */
class NotSpec extends ObjectBehavior
{
    public function let(Filter $filterExpr)
    {
        $this->beConstructedWith($filterExpr, null);
    }

    /**
     * calls parent.
     */
    public function it_calls_parent_match(QueryBuilder $qb, Expr $expr, Filter $filterExpr)
    {
        $dqlAlias = 'a';
        $expression = 'expression';
        $parentExpression = 'foobar';

        $qb->expr()->willReturn($expr);
        $filterExpr->getFilter($qb, $dqlAlias)->willReturn($parentExpression);

        $expr->not($parentExpression)->willReturn($expression);

        $this->getFilter($qb, $dqlAlias)->shouldReturn($expression);
    }

    /**
     * modifies parent query.
     */
    public function it_modifies_parent_query(QueryBuilder $qb, Specification $spec)
    {
        $this->beConstructedWith($spec, null);

        $spec->modify($qb, 'a')->shouldBeCalled();
        $this->modify($qb, 'a');
    }

    public function it_does_not_modify_parent_query(QueryBuilder $qb)
    {
        $this->modify($qb, 'a');
    }
}
