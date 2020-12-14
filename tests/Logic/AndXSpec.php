<?php
declare(strict_types=1);

/**
 * This file is part of the Happyr Doctrine Specification package.
 *
 * (c) Tobias Nyholm <tobias@happyr.com>
 *     Kacper Gunia <kacper@gunia.me>
 *     Peter Gribanov <info@peter-gribanov.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Logic\AndX;
use Happyr\DoctrineSpecification\Specification\Specification;
use PhpSpec\ObjectBehavior;

/**
 * @mixin AndX
 */
final class AndXSpec extends ObjectBehavior
{
    public function let(Specification $specificationA, Specification $specificationB): void
    {
        $this->beConstructedWith($specificationA, $specificationB);
    }

    public function it_is_a_specification(): void
    {
        $this->shouldHaveType(Specification::class);
    }

    public function it_modifies_all_child_queries(
        QueryBuilder $queryBuilder,
        Specification $specificationA,
        Specification $specificationB
    ): void {
        $context = 'a';

        $specificationA->modify($queryBuilder, $context)->shouldBeCalled();
        $specificationB->modify($queryBuilder, $context)->shouldBeCalled();

        $this->modify($queryBuilder, $context);
    }

    public function it_composes_and_child_with_expression(
        QueryBuilder $qb,
        Expr $expression,
        Specification $specificationA,
        Specification $specificationB
    ): void {
        $filterA = 'foo';
        $filterB = 'bar';
        $context = 'a';

        $specificationA->getFilter($qb, $context)->willReturn($filterA);
        $specificationB->getFilter($qb, $context)->willReturn($filterB);
        $qb->expr()->willReturn($expression);

        $expression->andX($filterA, $filterB)->shouldBeCalled();

        $this->getFilter($qb, $context);
    }

    public function it_supports_expressions(QueryBuilder $qb, Expr $expression, Filter $exprA, Filter $exprB): void
    {
        $this->beConstructedWith($exprA, $exprB);

        $filterA = 'foo';
        $filterB = 'bar';
        $context = 'a';

        $exprA->getFilter($qb, $context)->willReturn($filterA);
        $exprB->getFilter($qb, $context)->willReturn($filterB);
        $qb->expr()->willReturn($expression);

        $expression->andX($filterA, $filterB)->shouldBeCalled();

        $this->getFilter($qb, $context);
    }
}
