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
use Happyr\DoctrineSpecification\Filter\IsNull;
use PhpSpec\ObjectBehavior;
use tests\Happyr\DoctrineSpecification\Game;
use tests\Happyr\DoctrineSpecification\Player;

/**
 * @mixin IsNull
 */
final class IsNullSpec extends ObjectBehavior
{
    private $field = 'foobar';

    public function let(): void
    {
        $this->beConstructedWith($this->field, null);
    }

    public function it_is_an_expression(): void
    {
        $this->shouldBeAnInstanceOf(Filter::class);
    }

    /**
     * returns expression func object.
     */
    public function it_calls_null(QueryBuilder $qb, Expr $expr): void
    {
        $expression = 'a.foobar is null';

        $qb->expr()->willReturn($expr);
        $expr->isNull(sprintf('a.%s', $this->field))->willReturn($expression);

        $this->getFilter($qb, 'a')->shouldReturn($expression);
    }

    public function it_calls_null_in_context(QueryBuilder $qb, Expr $expr): void
    {
        $this->beConstructedWith($this->field, 'user');
        $qb->expr()->willReturn($expr);

        $expr->isNull(sprintf('user.%s', $this->field))->shouldBeCalled();

        $qb->getDQLPart('join')->willReturn([]);
        $qb->getAllAliases()->willReturn([]);
        $qb->join('root.user', 'user')->willReturn($qb);

        $this->getFilter($qb, 'root');
    }

    public function it_filter_array_collection(): void
    {
        $this->beConstructedWith('points', null);

        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => null],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001],
        ];

        $this->filterCollection($players)->shouldYield([$players[1]]);
    }

    public function it_filter_object_collection(): void
    {
        $this->beConstructedWith('points', null);

        $players = [
            new Player('Joe', 'M', 2500),
            new Player('Moe', 'M', null),
            new Player('Alice', 'F', 9001),
        ];

        $this->filterCollection($players)->shouldYield([$players[1]]);
    }

    public function it_is_satisfied_with_array(): void
    {
        $this->beConstructedWith('points', null);

        $playerA = ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500];
        $playerB = ['pseudo' => 'Moe',   'gender' => 'M', 'points' => null];
        $playerC = ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001];

        $this->isSatisfiedBy($playerA)->shouldBe(false);
        $this->isSatisfiedBy($playerB)->shouldBe(true);
        $this->isSatisfiedBy($playerC)->shouldBe(false);
    }

    public function it_is_satisfied_with_object(): void
    {
        $this->beConstructedWith('points', null);

        $playerA = new Player('Joe', 'M', 2500);
        $playerB = new Player('Moe', 'M', null);
        $playerC = new Player('Alice', 'F', 9001);

        $this->isSatisfiedBy($playerA)->shouldBe(false);
        $this->isSatisfiedBy($playerB)->shouldBe(true);
        $this->isSatisfiedBy($playerC)->shouldBe(false);
    }

    public function it_is_satisfied_in_context_with_array(): void
    {
        $game = ['name' => 'Tetris'];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->beConstructedWith('releaseAt', 'inGame');

        $this->isSatisfiedBy($player)->shouldBe(true);
    }

    public function it_is_satisfied_in_context_with_object(): void
    {
        $game = new Game('Tetris');
        $player = new Player('Moe', 'M', 1230, $game);

        $this->beConstructedWith('releaseAt', 'inGame');

        $this->isSatisfiedBy($player)->shouldBe(true);
    }

    public function it_filter_array_collection_in_context(): void
    {
        $releaseAt = new \DateTimeImmutable();
        $tetris = ['name' => 'Tetris', 'releaseAt' => null];
        $mahjong = ['name' => 'Mahjong', 'releaseAt' => $releaseAt];
        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500, 'inGame' => $mahjong],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230, 'inGame' => $mahjong],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001, 'inGame' => $tetris],
        ];

        $this->beConstructedWith('releaseAt', 'inGame');

        $this->filterCollection($players)->shouldYield([$players[2]]);
    }

    public function it_filter_array_collection_in_global_context(): void
    {
        $releaseAt = new \DateTimeImmutable();
        $tetris = ['name' => 'Tetris', 'releaseAt' => null];
        $mahjong = ['name' => 'Mahjong', 'releaseAt' => $releaseAt];
        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500, 'inGame' => $mahjong],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230, 'inGame' => $mahjong],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001, 'inGame' => $tetris],
        ];

        $this->beConstructedWith('releaseAt', null);

        $this->filterCollection($players, 'inGame')->shouldYield([$players[2]]);
    }

    public function it_is_satisfied_in_global_context(): void
    {
        $game = ['name' => 'Tetris', 'releaseAt' => null];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->beConstructedWith('releaseAt', null);

        $this->isSatisfiedBy($player, 'inGame')->shouldBe(true);
    }

    public function it_filter_array_collection_in_combo_context(): void
    {
        $tetrisOwner = ['name' => 'ABC', 'based' => null];
        $mahjongOwner = ['name' => 'DEF', 'based' => 321];
        $tetris = ['name' => 'Tetris', 'owner' => $tetrisOwner];
        $mahjong = ['name' => 'Mahjong', 'owner' => $mahjongOwner];
        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500, 'inGame' => $mahjong],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230, 'inGame' => $mahjong],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001, 'inGame' => $tetris],
        ];

        $this->beConstructedWith('based', 'owner');

        $this->filterCollection($players, 'inGame')->shouldYield([$players[2]]);
    }

    public function it_is_satisfied_in_combo_context(): void
    {
        $owner = ['name' => 'ABC', 'based' => null];
        $game = ['name' => 'Tetris', 'owner' => $owner];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->beConstructedWith('based', 'owner');

        $this->isSatisfiedBy($player, 'inGame')->shouldBe(true);
    }
}
