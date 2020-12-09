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
use Happyr\DoctrineSpecification\Logic\Not;
use Happyr\DoctrineSpecification\Specification\Specification;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Not
 */
final class NotSpec extends ObjectBehavior
{
    public function let(Filter $filterExpr): void
    {
        $this->beConstructedWith($filterExpr, null);
    }

    /**
     * calls parent.
     */
    public function it_calls_parent_match(QueryBuilder $qb, Expr $expr, Filter $filterExpr): void
    {
        $dqlAlias = 'a';
        $expression = 'expression';
        $parentExpression = 'foobar';

        $qb->expr()->willReturn($expr);
        $filterExpr->getFilter($qb, $dqlAlias)->willReturn($parentExpression);

        $expr->not($parentExpression)->willReturn($expression);

        $this->getFilter($qb, $dqlAlias)->shouldReturn($expression);
    }

    /**
     * modifies parent query.
     */
    public function it_modifies_parent_query(QueryBuilder $qb, Specification $spec): void
    {
        $this->beConstructedWith($spec, null);

        $spec->modify($qb, 'a')->shouldBeCalled();
        $this->modify($qb, 'a');
    }

    public function it_does_not_modify_parent_query(QueryBuilder $qb): void
    {
        $this->modify($qb, 'a');
    }
}
