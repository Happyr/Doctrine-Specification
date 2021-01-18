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

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Filter\IsNotNull;
use PhpSpec\ObjectBehavior;
use tests\Happyr\DoctrineSpecification\Player;

/**
 * @mixin IsNotNull
 */
final class IsNotNullSpec extends ObjectBehavior
{
    private $field = 'foobar';

    private $context = 'a';

    public function let(): void
    {
        $this->beConstructedWith($this->field, $this->context);
    }

    public function it_is_an_expression(): void
    {
        $this->shouldBeAnInstanceOf(Filter::class);
    }

    /**
     * returns expression func object.
     */
    public function it_calls_not_null(QueryBuilder $qb, Expr $expr): void
    {
        $expression = 'a.foobar is not null';

        $qb->expr()->willReturn($expr);
        $expr->isNotNull(sprintf('%s.%s', $this->context, $this->field))->willReturn($expression);

        $this->getFilter($qb, $this->context)->shouldReturn($expression);
    }

    public function it_uses_dql_alias_if_passed(QueryBuilder $qb, Expr $expr): void
    {
        $context = 'x';
        $this->beConstructedWith($this->field, null);
        $qb->expr()->willReturn($expr);

        $expr->isNotNull(sprintf('%s.%s', $context, $this->field))->shouldBeCalled();
        $this->getFilter($qb, $context);
    }

    public function it_filter_array_collection(): void
    {
        $this->beConstructedWith('points', null);

        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => null],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001],
        ];

        $this->filterCollection($players)->shouldYield([$players[0], $players[2]]);
    }

    public function it_filter_object_collection(): void
    {
        $this->beConstructedWith('points', null);

        $players = [
            new Player('Joe', 'M', 2500),
            new Player('Moe', 'M', null),
            new Player('Alice', 'F', 9001),
        ];

        $this->filterCollection($players)->shouldYield([$players[0], $players[2]]);
    }

    public function it_is_satisfied_with_array(): void
    {
        $this->beConstructedWith('points', null);

        $playerA = ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500];
        $playerB = ['pseudo' => 'Moe',   'gender' => 'M', 'points' => null];
        $playerC = ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001];

        $this->isSatisfiedBy($playerA)->shouldBe(true);
        $this->isSatisfiedBy($playerB)->shouldBe(false);
        $this->isSatisfiedBy($playerC)->shouldBe(true);
    }

    public function it_is_satisfied_with_object(): void
    {
        $this->beConstructedWith('points', null);

        $playerA = new Player('Joe', 'M', 2500);
        $playerB = new Player('Moe', 'M', null);
        $playerC = new Player('Alice', 'F', 9001);

        $this->isSatisfiedBy($playerA)->shouldBe(true);
        $this->isSatisfiedBy($playerB)->shouldBe(false);
        $this->isSatisfiedBy($playerC)->shouldBe(true);
    }
}
