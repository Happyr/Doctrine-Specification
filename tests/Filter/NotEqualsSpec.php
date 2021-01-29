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
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Filter\NotEquals;
use PhpSpec\ObjectBehavior;
use tests\Happyr\DoctrineSpecification\Game;
use tests\Happyr\DoctrineSpecification\Player;

/**
 * @mixin NotEquals
 */
final class NotEqualsSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('age', 18, null);
    }

    public function it_is_an_expression(): void
    {
        $this->shouldBeAnInstanceOf(Filter::class);
    }

    public function it_returns_comparison_object(QueryBuilder $qb, ArrayCollection $parameters): void
    {
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 18, null)->shouldBeCalled();

        $comparison = $this->getFilter($qb, 'a');

        $comparison->shouldReturn('a.age <> :comparison_10');
    }

    public function it_returns_comparison_object_in_context(QueryBuilder $qb, ArrayCollection $parameters): void
    {
        $this->beConstructedWith('age', 18, 'user');

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 18, null)->shouldBeCalled();

        $qb->getDQLPart('join')->willReturn([]);
        $qb->getAllAliases()->willReturn([]);
        $qb->join('root.user', 'user')->willReturn($qb);

        $this->getFilter($qb, 'root')->shouldReturn('user.age <> :comparison_10');
    }

    public function it_filter_array_collection(): void
    {
        $this->beConstructedWith('gender', 'M', null);

        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001],
        ];

        $this->filterCollection($players)->shouldYield([$players[2]]);
    }

    public function it_filter_object_collection(): void
    {
        $this->beConstructedWith('gender', 'M', null);

        $players = [
            new Player('Joe', 'M', 2500),
            new Player('Moe', 'M', 1230),
            new Player('Alice', 'F', 9001),
        ];

        $this->filterCollection($players)->shouldYield([$players[2]]);
    }

    public function it_is_satisfied_with_array(): void
    {
        $this->beConstructedWith('gender', 'M', null);

        $playerA = ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500];
        $playerB = ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001];

        $this->isSatisfiedBy($playerA)->shouldBe(false);
        $this->isSatisfiedBy($playerB)->shouldBe(true);
    }

    public function it_is_satisfied_with_object(): void
    {
        $this->beConstructedWith('gender', 'M', null);

        $playerA = new Player('Joe', 'M', 2500);
        $playerB = new Player('Alice', 'F', 9001);

        $this->isSatisfiedBy($playerA)->shouldBe(false);
        $this->isSatisfiedBy($playerB)->shouldBe(true);
    }

    public function it_is_satisfied_in_context_with_array(): void
    {
        $game = ['name' => 'Tetris'];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->beConstructedWith('name', 'Mahjong', 'inGame');

        $this->isSatisfiedBy($player)->shouldBe(true);
    }

    public function it_is_satisfied_in_context_with_object(): void
    {
        $game = new Game('Tetris');
        $player = new Player('Moe', 'M', 1230, $game);

        $this->beConstructedWith('name', 'Mahjong', 'inGame');

        $this->isSatisfiedBy($player)->shouldBe(true);
    }

    public function it_filter_array_collection_in_context(): void
    {
        $tetris = ['name' => 'Tetris'];
        $mahjong = ['name' => 'Mahjong'];
        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500, 'inGame' => $mahjong],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230, 'inGame' => $mahjong],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001, 'inGame' => $tetris],
        ];

        $this->beConstructedWith('name', 'Mahjong', 'inGame');

        $this->filterCollection($players)->shouldYield([$players[2]]);
    }

    public function it_filter_array_collection_in_global_context(): void
    {
        $tetris = ['name' => 'Tetris'];
        $mahjong = ['name' => 'Mahjong'];
        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500, 'inGame' => $mahjong],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230, 'inGame' => $mahjong],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001, 'inGame' => $tetris],
        ];

        $this->beConstructedWith('name', 'Mahjong', null);

        $this->filterCollection($players, 'inGame')->shouldYield([$players[2]]);
    }

    public function it_is_satisfied_in_global_context(): void
    {
        $game = ['name' => 'Tetris'];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->beConstructedWith('name', 'Mahjong', null);

        $this->isSatisfiedBy($player, 'inGame')->shouldBe(true);
    }

    public function it_filter_array_collection_in_combo_context(): void
    {
        $tetrisOwner = ['name' => 'ABC', 'based' => 123];
        $mahjongOwner = ['name' => 'DEF', 'based' => 321];
        $tetris = ['name' => 'Tetris', 'owner' => $tetrisOwner];
        $mahjong = ['name' => 'Mahjong', 'owner' => $mahjongOwner];
        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500, 'inGame' => $mahjong],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230, 'inGame' => $mahjong],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001, 'inGame' => $tetris],
        ];

        $this->beConstructedWith('name', 'DEF', 'owner');

        $this->filterCollection($players, 'inGame')->shouldYield([$players[2]]);
    }

    public function it_is_satisfied_in_combo_context(): void
    {
        $owner = ['name' => 'ABC', 'based' => 123];
        $game = ['name' => 'Tetris', 'owner' => $owner];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->beConstructedWith('name', 'DEF', 'owner');

        $this->isSatisfiedBy($player, 'inGame')->shouldBe(true);
    }
}
