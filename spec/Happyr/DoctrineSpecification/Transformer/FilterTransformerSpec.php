<?php


namespace spec\Happyr\DoctrineSpecification\Transformer;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Base\Comparison;
use Happyr\DoctrineSpecification\Filter\IsNotNull;
use Happyr\DoctrineSpecification\Filter\IsNull;
use Happyr\DoctrineSpecification\ParametersBag;
use Happyr\DoctrineSpecification\Specification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilterTransformerSpec extends ObjectBehavior
{
    function it_should_transform_is_not_null(QueryBuilder $queryBuilder, Expr $expr, Specification $specification, ParametersBag $parameters)
    {
        $queryBuilder->expr()->willReturn($expr);
        $expr->isNotNull('field')->willReturn('field IS NOT NULL');
        $this->setQueryBuilder($queryBuilder);

        $this->transform(new IsNotNull('field'), $parameters)->shouldReturn('field IS NOT NULL');
    }

    function it_should_transform_is_null(QueryBuilder $queryBuilder, Expr $expr, Specification $specification, ParametersBag $parameters)
    {
        $queryBuilder->expr()->willReturn($expr);
        $expr->isNull('field')->willReturn('field IS NULL');
        $this->setQueryBuilder($queryBuilder);

        $this->transform(new IsNull('field'), $parameters)->shouldReturn('field IS NULL');
    }

    function it_should_throw_exception_for_unsupported_filter(QueryBuilder $queryBuilder, Expr $expr, ParametersBag $parameters, Comparison $comparision)
    {
        $this->shouldThrow('Happyr\DoctrineSpecification\Exception\InvalidArgumentException')->duringTransform($comparision, $parameters);
    }

    function it_support_filters()
    {
        $this->supports(new IsNull('f'))->shouldReturn(true);
        $this->supports(new IsNotNull('f'))->shouldReturn(true);
    }
}
