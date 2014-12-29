<?php

namespace spec\Happyr\DoctrineSpecification\Transformer;

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
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\DoctrineQueryBuilderTransformer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin DoctrineQueryBuilderTransformer
 */
class DoctrineQueryBuilderTransformerSpec extends ObjectBehavior
{
    function let(QueryBuilder $queryBuilder)
    {
        $this->beConstructedWith($queryBuilder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Transformer\DoctrineQueryBuilderTransformer');
    }

    function it_can_transform_filter_equals_to_query(QueryBuilder $queryBuilder, Expr $expr, Specification $specification)
    {
        $queryBuilder->expr()->willReturn($expr);
        $queryBuilder->add('where', 'field = ?1')->shouldBeCalled();
        $expr->eq('field', '?1')->willReturn('field = ?1');
        $queryBuilder->setParameters([
            1 => 'value'
        ])->shouldBeCalled();

        $expression = new Equals('field', 'value');
        $specification->getFilter()->willReturn($expression);
        $this->getQueryBuilder($specification);
    }

    function it_can_transform_filter_greater_or_equal_than_to_query(QueryBuilder $queryBuilder, Expr $expr, Specification $specification)
    {
        $queryBuilder->expr()->willReturn($expr);
        $queryBuilder->add('where', 'field >= ?1')->shouldBeCalled();
        $expr->gte('field', '?1')->willReturn('field >= ?1');
        $queryBuilder->setParameters([
            1 => 'value'
        ])->shouldBeCalled();

        $expression = new GreaterOrEqualThan('field', 'value');
        $specification->getFilter()->willReturn($expression);
        $this->getQueryBuilder($specification);
    }

    function it_can_transform_filter_greater_than_to_query(QueryBuilder $queryBuilder, Expr $expr, Specification $specification)
    {
        $queryBuilder->expr()->willReturn($expr);
        $queryBuilder->add('where', 'field > ?1')->shouldBeCalled();
        $expr->gt('field', '?1')->willReturn('field > ?1');
        $queryBuilder->setParameters([
            1 => 'value'
        ])->shouldBeCalled();

        $expression = new GreaterThan('field', 'value');
        $specification->getFilter()->willReturn($expression);
        $this->getQueryBuilder($specification);
    }

    function it_can_transform_filter_in_to_query(QueryBuilder $queryBuilder, Expr $expr, Specification $specification)
    {
        $queryBuilder->expr()->willReturn($expr);
        $queryBuilder->add('where', 'field IN (\'?1\')')->shouldBeCalled();
        $expr->in('field', '?1')->willReturn('field IN (\'?1\')');
        $queryBuilder->setParameters([
            1 => [1,2,3]
        ])->shouldBeCalled();

        $expression = new In('field', [1,2,3]);
        $specification->getFilter()->willReturn($expression);
        $this->getQueryBuilder($specification);
    }

    function it_can_transform_filter_is_not_null_to_query(QueryBuilder $queryBuilder, Expr $expr, Specification $specification)
    {
        $queryBuilder->expr()->willReturn($expr);
        $queryBuilder->add('where', 'field IS NOT NULL')->shouldBeCalled();
        $expr->isNotNull('field')->willReturn('field IS NOT NULL');

        $expression = new IsNotNull('field');
        $specification->getFilter()->willReturn($expression);
        $this->getQueryBuilder($specification);
    }

    function it_can_transform_filter_is_null_to_query(QueryBuilder $queryBuilder, Expr $expr, Specification $specification)
    {
        $queryBuilder->expr()->willReturn($expr);
        $queryBuilder->add('where', 'field IS NULL')->shouldBeCalled();
        $expr->isNull('field')->willReturn('field IS NULL');

        $expression = new IsNull('field');
        $specification->getFilter()->willReturn($expression);
        $this->getQueryBuilder($specification);
    }

    function it_can_transform_filter_less_or_equal_than_to_query(QueryBuilder $queryBuilder, Expr $expr, Specification $specification)
    {
        $queryBuilder->expr()->willReturn($expr);
        $queryBuilder->add('where', 'field <= ?1')->shouldBeCalled();
        $expr->lte('field', '?1')->willReturn('field <= ?1');
        $queryBuilder->setParameters([
            1 => 'value'
        ])->shouldBeCalled();

        $expression = new LessOrEqualThan('field', 'value');
        $specification->getFilter()->willReturn($expression);
        $this->getQueryBuilder($specification);
    }

    function it_can_transform_filter_less_than_to_query(QueryBuilder $queryBuilder, Expr $expr, Specification $specification)
    {
        $queryBuilder->expr()->willReturn($expr);
        $queryBuilder->add('where', 'field < ?1')->shouldBeCalled();
        $expr->lt('field', '?1')->willReturn('field < ?1');
        $queryBuilder->setParameters([
            1 => 'value'
        ])->shouldBeCalled();

        $expression = new LessThan('field', 'value');
        $specification->getFilter()->willReturn($expression);
        $this->getQueryBuilder($specification);
    }

    function it_can_transform_filter_like_contains_to_query(QueryBuilder $queryBuilder, Expr $expr, Specification $specification)
    {
        $queryBuilder->expr()->willReturn($expr);
        $queryBuilder->add('where', 'field like ?1')->shouldBeCalled();
        $expr->like('field', '?1')->willReturn('field like ?1');
        $queryBuilder->setParameters([
            1 => '%value%'
        ])->shouldBeCalled();

        $expression = new Like('field', 'value', Like::CONTAINS);
        $specification->getFilter()->willReturn($expression);
        $this->getQueryBuilder($specification);
    }

    function it_can_transform_filter_like_starts_with_to_query(QueryBuilder $queryBuilder, Expr $expr, Specification $specification)
    {
        $queryBuilder->expr()->willReturn($expr);
        $queryBuilder->add('where', 'field like ?1')->shouldBeCalled();
        $expr->like('field', '?1')->willReturn('field like ?1');
        $queryBuilder->setParameters([
            1 => '%value'
        ])->shouldBeCalled();

        $expression = new Like('field', 'value', Like::STARTS_WITH);
        $specification->getFilter()->willReturn($expression);
        $this->getQueryBuilder($specification);
    }

    function it_can_transform_filter_like_ends_with_to_query(QueryBuilder $queryBuilder, Expr $expr, Specification $specification)
    {
        $queryBuilder->expr()->willReturn($expr);
        $queryBuilder->add('where', 'field like ?1')->shouldBeCalled();
        $expr->like('field', '?1')->willReturn('field like ?1');
        $queryBuilder->setParameters([
            1 => 'value%'
        ])->shouldBeCalled();

        $expression = new Like('field', 'value', Like::ENDS_WITH);
        $specification->getFilter()->willReturn($expression);
        $this->getQueryBuilder($specification);
    }

    function it_can_transform_filter_not_equals_to_query(QueryBuilder $queryBuilder, Expr $expr, Specification $specification)
    {
        $queryBuilder->expr()->willReturn($expr);
        $queryBuilder->add('where', 'field <> ?1')->shouldBeCalled();
        $expr->neq('field', '?1')->willReturn('field <> ?1');
        $queryBuilder->setParameters([
            1 => 'value'
        ])->shouldBeCalled();

        $expression = new NotEquals('field', 'value');
        $specification->getFilter()->willReturn($expression);
        $this->getQueryBuilder($specification);
    }
}
