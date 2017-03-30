<?php

namespace tests\Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\IsNotNull;
use PhpSpec\ObjectBehavior;

/**
 * @mixin IsNotNull
 */
class IsNotNullSpec extends ObjectBehavior
{
    private $field = 'foobar';

    private $dqlAlias = 'a';

    public function let()
    {
        $this->beConstructedWith($this->field, $this->dqlAlias);
    }

    public function it_is_an_expression()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Filter\Filter');
    }

    /**
     * returns expression func object.
     */
    public function it_calls_not_null(QueryBuilder $qb, Expr $expr)
    {
        $expression = 'a.foobar is not null';

        $qb->expr()->willReturn($expr);
        $expr->isNotNull(sprintf('%s.%s', $this->dqlAlias, $this->field))->willReturn($expression);

        $this->getFilter($qb, null)->shouldReturn($expression);
    }

    public function it_uses_dql_alias_if_passed(QueryBuilder $qb, Expr $expr)
    {
        $dqlAlias = 'x';
        $this->beConstructedWith($this->field, null);
        $qb->expr()->willReturn($expr);

        $expr->isNotNull(sprintf('%s.%s', $dqlAlias, $this->field))->shouldBeCalled();
        $this->getFilter($qb, $dqlAlias);
    }
}
