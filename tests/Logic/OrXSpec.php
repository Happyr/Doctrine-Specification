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
use Happyr\DoctrineSpecification\Logic\OrX;
use Happyr\DoctrineSpecification\Specification\Specification;
use PhpSpec\ObjectBehavior;

/**
 * @mixin OrX
 */
class OrXSpec extends ObjectBehavior
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
        $dqlAlias = 'a';

        $specificationA->modify($queryBuilder, $dqlAlias)->shouldBeCalled();
        $specificationB->modify($queryBuilder, $dqlAlias)->shouldBeCalled();

        $this->modify($queryBuilder, $dqlAlias);
    }

    public function it_composes_and_child_with_expression(
        QueryBuilder $qb,
        Expr $expression,
        Specification $specificationA,
        Specification $specificationB
    ): void {
        $filterA = 'foo';
        $filterB = 'bar';
        $dqlAlias = 'a';

        $specificationA->getFilter($qb, $dqlAlias)->willReturn($filterA);
        $specificationB->getFilter($qb, $dqlAlias)->willReturn($filterB);
        $qb->expr()->willReturn($expression);

        $expression->orX($filterA, $filterB)->shouldBeCalled();

        $this->getFilter($qb, $dqlAlias);
    }

    public function it_supports_expressions(
        QueryBuilder $qb,
        Expr $expression,
        Filter $exprA,
        Filter $exprB
    ): void {
        $this->beConstructedWith($exprA, $exprB);

        $filterA = 'foo';
        $filterB = 'bar';
        $dqlAlias = 'a';

        $exprA->getFilter($qb, $dqlAlias)->willReturn($filterA);
        $exprB->getFilter($qb, $dqlAlias)->willReturn($filterB);
        $qb->expr()->willReturn($expression);

        $expression->orX($filterA, $filterB)->shouldBeCalled();

        $this->getFilter($qb, $dqlAlias);
    }
}
