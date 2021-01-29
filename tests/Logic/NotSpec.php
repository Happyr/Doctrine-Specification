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
use Happyr\DoctrineSpecification\Filter\Equals;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Logic\Not;
use Happyr\DoctrineSpecification\Specification\Specification;
use PhpSpec\ObjectBehavior;
use tests\Happyr\DoctrineSpecification\Game;
use tests\Happyr\DoctrineSpecification\Player;

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
        $context = 'a';
        $expression = 'expression';
        $parentExpression = 'foobar';

        $qb->expr()->willReturn($expr);
        $filterExpr->getFilter($qb, $context)->willReturn($parentExpression);

        $expr->not($parentExpression)->willReturn($expression);

        $this->getFilter($qb, $context)->shouldReturn($expression);
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

    public function it_filter_array_collection(): void
    {
        $this->beConstructedWith(new Equals('gender', 'M'));

        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001],
        ];

        $this->filterCollection($players)->shouldYield([$players[2]]);
    }

    public function it_filter_object_collection(): void
    {
        $this->beConstructedWith(new Equals('gender', 'M'));

        $players = [
            new Player('Joe', 'M', 2500),
            new Player('Moe', 'M', 1230),
            new Player('Alice', 'F', 9001),
        ];

        $this->filterCollection($players)->shouldYield([$players[2]]);
    }

    public function it_filter_array_collection_not_satisfiable(Filter $expr): void
    {
        $this->beConstructedWith($expr);

        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001],
        ];

        $this->filterCollection($players)->shouldNotYield([]);
    }

    public function it_filter_object_collection_not_satisfiable(Filter $expr): void
    {
        $this->beConstructedWith($expr);

        $players = [
            new Player('Joe', 'M', 2500),
            new Player('Moe', 'M', 1230),
            new Player('Alice', 'F', 9001),
        ];

        $this->filterCollection($players)->shouldNotYield([]);
    }

    public function it_is_satisfied_with_array(): void
    {
        $this->beConstructedWith(new Equals('gender', 'M'));

        $playerA = ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500];
        $playerB = ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001];

        $this->isSatisfiedBy($playerA)->shouldBe(false);
        $this->isSatisfiedBy($playerB)->shouldBe(true);
    }

    public function it_is_satisfied_with_object(): void
    {
        $this->beConstructedWith(new Equals('gender', 'M'));

        $playerA = new Player('Joe', 'M', 2500);
        $playerB = new Player('Alice', 'F', 9001);

        $this->isSatisfiedBy($playerA)->shouldBe(false);
        $this->isSatisfiedBy($playerB)->shouldBe(true);
    }

    public function it_is_satisfied_with_array_not_satisfiable(Filter $expr): void
    {
        $this->beConstructedWith($expr);

        $player = ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001];

        $this->isSatisfiedBy($player)->shouldBe(true);
    }

    public function it_is_satisfied_with_object_not_satisfiable(Filter $expr): void
    {
        $this->beConstructedWith($expr);

        $player = new Player('Alice', 'F', 9001);

        $this->isSatisfiedBy($player)->shouldBe(true);
    }

    public function it_filter_array_collection_in_context(): void
    {
        $this->beConstructedWith(new Equals('name', 'Mahjong'));

        $game = ['name' => 'Tetris'];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->filterCollection([$player], 'inGame')->shouldYield([$player]);
    }

    public function it_filter_object_collection_in_context(): void
    {
        $this->beConstructedWith(new Equals('name', 'Mahjong'));

        $game = new Game('Tetris');
        $player = new Player('Moe', 'M', 1230, $game);

        $this->filterCollection([$player], 'inGame')->shouldYield([$player]);
    }

    public function it_is_satisfied_array_collection_in_context(): void
    {
        $this->beConstructedWith(new Equals('name', 'Mahjong'));

        $game = ['name' => 'Tetris'];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->isSatisfiedBy($player, 'inGame')->shouldBe(true);
    }

    public function it_is_satisfied_object_collection_in_context(): void
    {
        $this->beConstructedWith(new Equals('name', 'Mahjong'));

        $game = new Game('Tetris');
        $player = new Player('Moe', 'M', 1230, $game);

        $this->isSatisfiedBy($player, 'inGame')->shouldBe(true);
    }
}
