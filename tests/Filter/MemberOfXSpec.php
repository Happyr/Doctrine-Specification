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

namespace tests\Happyr\DoctrineSpecification\Filter;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Comparison;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Filter\MemberOfX;
use PhpSpec\ObjectBehavior;

/**
 * @mixin MemberOfX
 */
final class MemberOfXSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(18, 'age', null);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MemberOfX::class);
    }

    public function it_is_an_expression(): void
    {
        $this->shouldBeAnInstanceOf(Filter::class);
    }

    public function it_returns_expression_func_object(QueryBuilder $qb, ArrayCollection $parameters, Expr $exp): void
    {
        $exp_comparison = new Comparison(':comparison_10', 'MEMBER OF', 'a.age');
        $qb->expr()->willReturn($exp);
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 18, null)->shouldBeCalled();
        $exp->isMemberOf(':comparison_10', 'a.age')->willReturn($exp_comparison);

        $this->getFilter($qb, 'a')->shouldReturn(':comparison_10 MEMBER OF a.age');
    }

    public function it_returns_expression_func_object_in_context(
        QueryBuilder $qb,
        ArrayCollection $parameters,
        Expr $exp
    ): void {
        $this->beConstructedWith(18, 'age', 'user');

        $exp_comparison = new Comparison(':comparison_10', 'MEMBER OF', 'user.age');
        $qb->expr()->willReturn($exp);
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 18, null)->shouldBeCalled();
        $exp->isMemberOf(':comparison_10', 'user.age')->willReturn($exp_comparison);

        $qb->getDQLPart('join')->willReturn([]);
        $qb->getAllAliases()->willReturn([]);
        $qb->join('root.user', 'user')->willReturn($qb);

        $this->getFilter($qb, 'root')->shouldReturn(':comparison_10 MEMBER OF user.age');
    }
}
