<?php

namespace spec\Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Specification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotSpec extends ObjectBehavior
{
    function let(Specification $spec)
    {
        $this->beConstructedWith($spec, null);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Logic\Not');
    }

    /**
     * calls parent
     */
    function it_calls_parent_match(QueryBuilder $qb, Expr $expr, Specification $spec)
    {
        $dqlAlias='a';
        $qb->expr()->willReturn($expr);
        $parentResult='foobar';
        $spec->match($qb, $dqlAlias)->willReturn($parentResult);

        $expr->not($parentResult)->shouldBeCalled();

        $this->match($qb, $dqlAlias);
    }

    /**
     * modifies parent query
     */
    function it_modifies_parent_query(AbstractQuery $query, Specification $spec)
    {
        $spec->modifyQuery($query)->shouldBeCalled();
        $this->modifyQuery($query);
    }
}
