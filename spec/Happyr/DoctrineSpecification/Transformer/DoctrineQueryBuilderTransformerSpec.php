<?php

namespace spec\Happyr\DoctrineSpecification\Transformer;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\IsNotNull;
use Happyr\DoctrineSpecification\Filter\IsNull;
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

    function it_can_transform_filter_is_null_to_query(QueryBuilder $queryBuilder, Expr $expr, Specification $specification)
    {
        $queryBuilder->expr()->willReturn($expr);
        $queryBuilder->add('where', 'field IS NULL')->shouldBeCalled();
        $expr->isNull('field')->willReturn('field IS NULL');

        $isNull = new IsNull('field');
        $specification->getFilter()->willReturn($isNull);
        $this->getQueryBuilder($specification);
    }

    function it_can_transform_filter_is_not_null_to_query(QueryBuilder $queryBuilder, Expr $expr, Specification $specification)
    {
        $queryBuilder->expr()->willReturn($expr);
        $queryBuilder->add('where', 'field IS NOT NULL')->shouldBeCalled();
        $expr->isNotNull('field')->willReturn('field IS NOT NULL');

        $isNotNull = new IsNotNull('field');
        $specification->getFilter()->willReturn($isNotNull);
        $this->getQueryBuilder($specification);
    }
}
