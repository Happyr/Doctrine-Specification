<?php

namespace tests\Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Query\Join;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin Join
 */
class JoinSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('user', 'authUser', 'a');
    }

    function it_is_a_specification()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Query\QueryModifier');
    }

    function it_joins_with_default_dql_alias(QueryBuilder $qb)
    {
        $qb->join('a.user', 'authUser')->shouldBeCalled();
        $this->modify($qb, 'a');
    }

    function it_uses_local_alias_if_global_was_not_set(QueryBuilder $qb)
    {
        $this->beConstructedWith('user', 'authUser');
        $qb->join('b.user', 'authUser')->shouldBeCalled();
        $this->modify($qb, 'b');
    }
}
