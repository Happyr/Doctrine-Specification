<?php

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
use Happyr\DoctrineSpecification\Logic\LogicX;
use Happyr\DoctrineSpecification\Specification\Specification;
use PhpSpec\ObjectBehavior;

/**
 * @mixin LogicX
 */
class LogicXSpec extends ObjectBehavior
{
    const EXPRESSION = 'andX';

    public function let(Specification $specificationA, Specification $specificationB)
    {
        $this->beConstructedWith(self::EXPRESSION, [$specificationA, $specificationB]);
    }

    public function it_is_a_specification()
    {
        $this->shouldHaveType(Specification::class);
    }

    public function it_modifies_all_child_queries(QueryBuilder $queryBuilder, Specification $specificationA, Specification $specificationB)
    {
        $dqlAlias = 'a';

        $specificationA->modify($queryBuilder, $dqlAlias)->shouldBeCalled();
        $specificationB->modify($queryBuilder, $dqlAlias)->shouldBeCalled();

        $this->modify($queryBuilder, $dqlAlias);
    }

    public function it_composes_and_child_with_expression(QueryBuilder $qb, Expr $expression, Specification $specificationA, Specification $specificationB, $x, $y)
    {
        $dqlAlias = 'a';

        $specificationA->getFilter($qb, $dqlAlias)->willReturn($x);
        $specificationB->getFilter($qb, $dqlAlias)->willReturn($y);
        $qb->expr()->willReturn($expression);

        $expression->{self::EXPRESSION}($x, $y)->shouldBeCalled();

        $this->getFilter($qb, $dqlAlias);
    }

    public function it_supports_expressions(QueryBuilder $qb, Expr $expression, Filter $exprA, Filter $exprB, $x, $y)
    {
        $this->beConstructedWith(self::EXPRESSION, [$exprA, $exprB]);

        $dqlAlias = 'a';

        $exprA->getFilter($qb, $dqlAlias)->willReturn($x);
        $exprB->getFilter($qb, $dqlAlias)->willReturn($y);
        $qb->expr()->willReturn($expression);

        $expression->{self::EXPRESSION}($x, $y)->shouldBeCalled();

        $this->getFilter($qb, $dqlAlias);
    }
}
