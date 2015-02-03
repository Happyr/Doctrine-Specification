<?php

namespace spec\Happyr\DoctrineSpecification;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Equals;
use Happyr\DoctrineSpecification\Filter\GreaterOrEqualThan;
use Happyr\DoctrineSpecification\Filter\GreaterThan;
use Happyr\DoctrineSpecification\Filter\In;
use Happyr\DoctrineSpecification\Filter\IsNotNull;
use Happyr\DoctrineSpecification\Filter\IsNull;
use Happyr\DoctrineSpecification\Filter\LessOrEqualThan;
use Happyr\DoctrineSpecification\Filter\LessThan;
use Happyr\DoctrineSpecification\Filter\Like;
use Happyr\DoctrineSpecification\Filter\NotEquals;
use Happyr\DoctrineSpecification\Logic\AndX;
use Happyr\DoctrineSpecification\Logic\Not;
use Happyr\DoctrineSpecification\Logic\OrX;
use Happyr\DoctrineSpecification\ParametersBag;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\DoctrineTransformer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin DoctrineTransformer
 */
class DoctrineTransformerSpec extends ObjectBehavior
{
    function let(QueryBuilder $queryBuilder, Expr $expr)
    {
        $queryBuilder->expr()->willReturn($expr);
        $this->beConstructedWith($queryBuilder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\DoctrineTransformer');
    }

    function it_should_transform_is_not_null(Expr $expr, ParametersBag $parameters)
    {
        $expr->isNotNull('field')->willReturn('field IS NOT NULL');
        $this->getDqlPart(new IsNotNull('field'), $parameters)->shouldReturn('field IS NOT NULL');
    }

    function it_should_transform_is_null(Expr $expr, ParametersBag $parameters)
    {
        $expr->isNull('field')->willReturn('field IS NULL');

        $this->getDqlPart(new IsNull('field'), $parameters)->shouldReturn('field IS NULL');
    }

    function it_should_transform_equals(Expr $expr, ParametersBag $parameters)
    {
        $parameters->getLastName()->willReturn('?1');
        $parameters->add(Argument::any())->shouldBeCalled();
        $expr->eq('field', '?1')->willReturn('field = ?1');

        $this->getDqlPart(new Equals('field', 'value'), $parameters)->shouldReturn('field = ?1');
    }

    function it_should_transform_greater_than_or_equals(Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->shouldBeCalled();
        $parameters->getLastName()->willReturn('?1');
        $expr->gte('field', '?1')->willReturn('field >= ?1');

        $this->getDqlPart(new GreaterOrEqualThan('field', 'value'), $parameters)->shouldReturn('field >= ?1');
    }

    function it_should_transform_greater_than(Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->shouldBeCalled();
        $parameters->getLastName()->willReturn('?1');
        $expr->gt('field', '?1')->willReturn('field > ?1');

        $this->getDqlPart(new GreaterThan('field', 'value'), $parameters)->shouldReturn('field > ?1');
    }

    function it_should_transform_in(Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->shouldBeCalled();
        $parameters->getLastName()->willReturn('?1');
        $expr->in('field', '?1')->willReturn('field IN (\'?1\')');

        $this->getDqlPart(new In('field', [1,2,3]), $parameters)->shouldReturn('field IN (\'?1\')');
    }

    function it_should_transform_less_or_equals(Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->shouldBeCalled();
        $parameters->getLastName()->willReturn('?1');
        $expr->lte('field', '?1')->willReturn('field <= ?1');

        $this->getDqlPart(new LessOrEqualThan('field', 'value'), $parameters)->shouldReturn('field <= ?1');
    }

    function it_should_transform_less_than_or_equals(Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->shouldBeCalled();
        $parameters->getLastName()->willReturn('?1');
        $expr->lt('field', '?1')->willReturn('field < ?1');

        $this->getDqlPart(new LessThan('field', 'value'), $parameters)->shouldReturn('field < ?1');
    }

    function it_should_transform_like_contains(Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->shouldBeCalled();
        $parameters->getLastName()->willReturn('?1');
        $expr->like('field', '?1')->willReturn('field like ?1');

        $this->getDqlPart(new Like('field', 'value', Like::CONTAINS), $parameters)->shouldReturn('field like ?1');
    }

    function it_should_transform_like_starts_with(Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->shouldBeCalled();
        $parameters->getLastName()->willReturn('?1');
        $expr->like('field', '?1')->willReturn('field like ?1');

        $this->getDqlPart(new Like('field', 'value', Like::STARTS_WITH), $parameters)->shouldReturn('field like ?1');
    }

    function it_should_transform_ends_with(Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->shouldBeCalled();
        $parameters->getLastName()->willReturn('?1');
        $expr->like('field', '?1')->willReturn('field like ?1');

        $this->getDqlPart(new Like('field', 'value', Like::ENDS_WITH), $parameters)->shouldReturn('field like ?1');
    }

    function it_should_transform_not_equals(Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->shouldBeCalled();
        $parameters->getLastName()->willReturn('?1');
        $expr->neq('field', '?1')->willReturn('field <> ?1');

        $this->getDqlPart(new NotEquals('field', 'value'), $parameters)->shouldReturn('field <> ?1');
    }

    function it_should_transform_not(Expr $expr, ParametersBag $parameters)
    {
        $parameters->getLastName()->willReturn('?1');
        $parameters->add(Argument::any())->shouldBeCalled();
        $expr->eq('field', '?1')->willReturn('field = ?1');
        $expr->not('field = ?1')->willReturn('NOT (field = ?1)');

        $this->getDqlPart(new Not(new Equals('field', 'value')), $parameters)->shouldReturn('NOT (field = ?1)');
    }

    function it_should_transform_and(Expr $expr)
    {
        $parameters = new ParametersBag();

        $expr->eq('field', '?1')->willReturn('field = ?1');
        $expr->eq('field', '?2')->willReturn('field = ?2');
        $expr->andX('field = ?1', 'field = ?2')->willReturn('field = ?1 AND field = ?2');

        $this->getDqlPart(new AndX(new Equals('field', 'value1'), new Equals('field', 'value2')), $parameters)->shouldReturn('field = ?1 AND field = ?2');
    }

    function it_should_transform_or(Expr $expr)
    {
        $parameters = new ParametersBag();

        $expr->eq('field', '?1')->willReturn('field = ?1');
        $expr->eq('field', '?2')->willReturn('field = ?2');
        $expr->orX('field = ?1', 'field = ?2')->willReturn('field = ?1 OR field = ?2');

        $this->getDqlPart(new OrX(new Equals('field', 'value1'), new Equals('field', 'value2')), $parameters)->shouldReturn('field = ?1 OR field = ?2');
    }
}
