<?php

namespace spec\Happyr\Doctrine\Specification\Comparison;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IsNullSpec extends ObjectBehavior
{
    private $field='foobar';

    private $dqlAlias = 'a';

    function let()
    {
        $this->beConstructedWith($this->field, $this->dqlAlias);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\Doctrine\Specification\Comparison\IsNull');
    }

    /**
     * is a specification
     */
    function it_is_a_specification()
    {
        $this->shouldHaveType('Happyr\Doctrine\Specification\Specification');
    }

    /**
     * returns expression func object
     */
    function it_calls_null(QueryBuilder $qb, Expr $expr)
    {
        $qb->expr()->willReturn($expr);

        $expr->isNull(sprintf('%s.%s', $this->dqlAlias, $this->field))->shouldBeCalled();
        $this->match($qb, 'b');
    }

    function it_uses_dql_alias_if_passed(QueryBuilder $qb, Expr $expr)
    {
        $dqlAlias='x';
        $this->beConstructedWith($this->field, null);
        $qb->expr()->willReturn($expr);

        $expr->isNull(sprintf('%s.%s', $dqlAlias, $this->field))->shouldBeCalled();
        $this->match($qb, $dqlAlias);
    }
}
