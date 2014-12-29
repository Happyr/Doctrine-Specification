<?php


namespace spec\Happyr\DoctrineSpecification\Transformer;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Filter\Base\Comparison;
use Happyr\DoctrineSpecification\Filter\Equals;
use Happyr\DoctrineSpecification\Filter\GreaterOrEqualThan;
use Happyr\DoctrineSpecification\Filter\GreaterThan;
use Happyr\DoctrineSpecification\Filter\In;
use Happyr\DoctrineSpecification\Filter\LessOrEqualThan;
use Happyr\DoctrineSpecification\Filter\LessThan;
use Happyr\DoctrineSpecification\Filter\Like;
use Happyr\DoctrineSpecification\Filter\NotEquals;
use Happyr\DoctrineSpecification\ParametersBag;
use Happyr\DoctrineSpecification\Specification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ComparisonTransformerSpec extends ObjectBehavior
{
    function it_should_transform_equals(QueryBuilder $queryBuilder, Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->willReturn('?1');
        $queryBuilder->expr()->willReturn($expr);
        $expr->eq('field', '?1')->willReturn('field = ?1');

        $this->setQueryBuilder($queryBuilder);
        $this->transform(new Equals('field', 'value'), $parameters)->shouldReturn('field = ?1');
    }

    function it_should_transform_greater_than_or_equals(QueryBuilder $queryBuilder, Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->willReturn('?1');
        $queryBuilder->expr()->willReturn($expr);
        $expr->gte('field', '?1')->willReturn('field >= ?1');

        $this->setQueryBuilder($queryBuilder);
        $this->transform(new GreaterOrEqualThan('field', 'value'), $parameters)->shouldReturn('field >= ?1');
    }

    function it_should_transform_greater_than(QueryBuilder $queryBuilder, Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->willReturn('?1');
        $queryBuilder->expr()->willReturn($expr);
        $expr->gt('field', '?1')->willReturn('field > ?1');

        $this->setQueryBuilder($queryBuilder);
        $this->transform(new GreaterThan('field', 'value'), $parameters)->shouldReturn('field > ?1');
    }

    function it_should_transform_in(QueryBuilder $queryBuilder, Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->willReturn('?1');
        $queryBuilder->expr()->willReturn($expr);
        $expr->in('field', '?1')->willReturn('field IN (\'?1\')');

        $this->setQueryBuilder($queryBuilder);
        $this->transform(new In('field', [1,2,3]), $parameters)->shouldReturn('field IN (\'?1\')');
    }

    function it_should_transform_less_or_equals(QueryBuilder $queryBuilder, Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->willReturn('?1');
        $queryBuilder->expr()->willReturn($expr);
        $expr->lte('field', '?1')->willReturn('field <= ?1');

        $this->setQueryBuilder($queryBuilder);
        $this->transform(new LessOrEqualThan('field', 'value'), $parameters)->shouldReturn('field <= ?1');
    }

    function it_should_transform_less_than_or_equals(QueryBuilder $queryBuilder, Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->willReturn('?1');
        $queryBuilder->expr()->willReturn($expr);
        $expr->lt('field', '?1')->willReturn('field < ?1');

        $this->setQueryBuilder($queryBuilder);
        $this->transform(new LessThan('field', 'value'), $parameters)->shouldReturn('field < ?1');
    }

    function it_should_transform_like_contains(QueryBuilder $queryBuilder, Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->willReturn('?1');
        $queryBuilder->expr()->willReturn($expr);
        $expr->like('field', '?1')->willReturn('field like ?1');

        $this->setQueryBuilder($queryBuilder);
        $this->transform(new Like('field', 'value', Like::CONTAINS), $parameters)->shouldReturn('field like ?1');
    }

    function it_should_transform_like_starts_with(QueryBuilder $queryBuilder, Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->willReturn('?1');
        $queryBuilder->expr()->willReturn($expr);
        $expr->like('field', '?1')->willReturn('field like ?1');

        $this->setQueryBuilder($queryBuilder);
        $this->transform(new Like('field', 'value', Like::STARTS_WITH), $parameters)->shouldReturn('field like ?1');
    }

    function it_should_transform_ends_with(QueryBuilder $queryBuilder, Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->willReturn('?1');
        $queryBuilder->expr()->willReturn($expr);
        $expr->like('field', '?1')->willReturn('field like ?1');

        $this->setQueryBuilder($queryBuilder);
        $this->transform(new Like('field', 'value', Like::ENDS_WITH), $parameters)->shouldReturn('field like ?1');
    }

    function it_should_transform_not_equals(QueryBuilder $queryBuilder, Expr $expr, ParametersBag $parameters)
    {
        $parameters->add(Argument::any())->willReturn('?1');
        $queryBuilder->expr()->willReturn($expr);
        $expr->neq('field', '?1')->willReturn('field <> ?1');

        $this->setQueryBuilder($queryBuilder);
        $this->transform(new NotEquals('field', 'value'), $parameters)->shouldReturn('field <> ?1');
    }

    function it_should_throw_exception_for_unsupported_filter(QueryBuilder $queryBuilder, Expr $expr, ParametersBag $parameters, Comparison $comparision)
    {
        $this->shouldThrow('Happyr\DoctrineSpecification\Exception\InvalidArgumentException')->duringTransform($comparision, $parameters);
    }

    function it_support_filters()
    {
        $this->supports(new Equals('f', 'v'))->shouldReturn(true);
        $this->supports(new NotEquals('f', 'v'))->shouldReturn(true);
        $this->supports(new GreaterOrEqualThan('f', 'v'))->shouldReturn(true);
        $this->supports(new GreaterThan('f', 'v'))->shouldReturn(true);
        $this->supports(new LessOrEqualThan('f', 'v'))->shouldReturn(true);
        $this->supports(new LessThan('f', 'v'))->shouldReturn(true);
        $this->supports(new In('f', 'v'))->shouldReturn(true);
        $this->supports(new Like('f', 'v'))->shouldReturn(true);
    }
}
