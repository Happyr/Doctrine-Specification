<?php
namespace spec\Happyr\DoctrineSpecification\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Query\LeftJoin;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
/**
 * @mixin LeftJoin
 */
class LeftJoinSpec extends ObjectBehavior
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
        $qb->leftJoin('b.user', 'authUser')->shouldBeCalled();
        $this->modify($qb, 'b');
    }
}
