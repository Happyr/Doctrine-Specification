<?php

namespace tests\Happyr\DoctrineSpecification\Filter;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\In;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin In
 */
class InSpec extends ObjectBehavior
{
    private $field='foobar';

    private $value=array('bar', 'baz');

    function let()
    {
        $this->beConstructedWith($this->field, $this->value, 'a');
    }

    function it_is_an_expression()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Filter\Filter');
    }

    function it_returns_expression_func_object(QueryBuilder $qb, ArrayCollection $parameters, Expr $expr)
    {
        $dqlAlias = 'a';
        $qb->expr()->willReturn($expr);
        $expr->in(sprintf('%s.%s', $dqlAlias, $this->field), ':in_10')->shouldBeCalled();

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('in_10', $this->value)->shouldBeCalled();

        $this->getFilter($qb, null);
    }
}
