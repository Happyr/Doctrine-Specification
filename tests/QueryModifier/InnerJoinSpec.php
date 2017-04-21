<?php

namespace tests\Happyr\DoctrineSpecification\QueryModifier;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\QueryModifier\InnerJoin;
use PhpSpec\ObjectBehavior;

/**
 * @mixin InnerJoin
 */
class InnerJoinSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('user', 'authUser', 'a');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\QueryModifier\InnerJoin');
    }

    public function it_is_a_specification()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\QueryModifier\QueryModifier');
    }

    public function it_joins_with_default_dql_alias(QueryBuilder $qb)
    {
        $qb->innerJoin('a.user', 'authUser')->shouldBeCalled();
        $this->modify($qb, 'a');
    }

    public function it_uses_local_alias_if_global_was_not_set(QueryBuilder $qb)
    {
        $this->beConstructedWith('user', 'authUser');
        $qb->innerJoin('b.user', 'authUser')->shouldBeCalled();
        $this->modify($qb, 'b');
    }
}
