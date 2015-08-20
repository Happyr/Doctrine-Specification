<?php

namespace tests\Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr;
use Happyr\DoctrineSpecification\Query\Join;
use Happyr\DoctrineSpecification\Filter;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Join
 */
class JoinSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('user', 'authUser', 'a');
    }

    public function it_is_a_specification()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Query\QueryModifier');
    }

    public function it_joins_with_default_dql_alias(QueryBuilder $qb)
    {
        $qb->join('a.user', 'authUser', null, null)->shouldBeCalled();
        $this->modify($qb, 'a');
    }

    public function it_uses_local_alias_if_global_was_not_set(QueryBuilder $qb)
    {
        $this->beConstructedWith('user', 'authUser');
        $qb->join('b.user', 'authUser', null, null)->shouldBeCalled();
        $this->modify($qb, 'b');
    }

    public function it_joins_with_simple_condition(QueryBuilder $qb)
    {
        $this->beConstructedWith('user', 'authUser', null, 'authUser.enabled = true');
        $qb->join('b.user', 'authUser', 'WITH', 'authUser.enabled = true')->shouldBeCalled();
        $this->modify($qb, 'b');
    }

    public function it_joins_with_array_of_simple_conditions(QueryBuilder $qb, Expr $expr, Expr\Andx $andX)
    {
        $this->beConstructedWith('user', 'authUser', null, [
            'authUser.enabled = true',
            'authUser.active = false'
        ]);

        $qb->expr()->willReturn($expr);
        $expr->andX(
            'authUser.enabled = true',
            'authUser.active = false'
        )->willReturn($andX);

        $qb->join('b.user', 'authUser', 'WITH', $andX)->shouldBeCalled();

        $this->modify($qb, 'b');
    }

    public function it_joins_with_filter_condition(QueryBuilder $qb, Filter\Equals $spec)
    {
        $spec->beConstructedWith(['enabled', 'true']);
        $this->beConstructedWith('user', 'authUser', null, $spec);

        $spec->getFilter($qb, 'authUser')->shouldBeCalled();
        $spec->getFilter($qb, 'authUser')->willReturn('authUser.enabled = true');
        $qb->join('b.user', 'authUser', 'WITH', 'authUser.enabled = true')->shouldBeCalled();

        $this->modify($qb, 'b');
    }
    
}
