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
use Happyr\DoctrineSpecification\Filter\Like;
use PhpSpec\ObjectBehavior;
use tests\Happyr\DoctrineSpecification\Game;
use tests\Happyr\DoctrineSpecification\Player;

/**
 * @mixin Like
 */
final class LikeSpec extends ObjectBehavior
{
    private $field = 'foo';

    private $value = 'bar';

    public function let(): void
    {
        $this->beConstructedWith($this->field, $this->value, Like::CONTAINS, null);
    }

    public function it_is_an_expression(): void
    {
        $this->shouldBeAnInstanceOf(Filter::class);
    }

    public function it_surrounds_with_wildcards_when_using_contains(
        QueryBuilder $qb,
        ArrayCollection $parameters
    ): void {
        $this->beConstructedWith($this->field, $this->value, Like::CONTAINS, null);
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(1);

        $qb->setParameter('comparison_1', '%bar%')->shouldBeCalled();

        $this->getFilter($qb, 'a');
    }

    public function it_surrounds_with_wildcards_when_using_contains_in_context(
        QueryBuilder $qb,
        ArrayCollection $parameters
    ): void {
        $this->beConstructedWith($this->field, $this->value, Like::CONTAINS, 'user');
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(1);

        $qb->setParameter('comparison_1', '%bar%')->shouldBeCalled();

        $qb->getDQLPart('join')->willReturn([]);
        $qb->getAllAliases()->willReturn([]);
        $qb->join('root.user', 'user')->willReturn($qb);

        $this->getFilter($qb, 'root');
    }

    public function it_starts_with_wildcard_when_using_ends_with(QueryBuilder $qb, ArrayCollection $parameters): void
    {
        $this->beConstructedWith($this->field, $this->value, Like::ENDS_WITH, null);
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(1);

        $qb->setParameter('comparison_1', '%bar')->shouldBeCalled();

        $this->getFilter($qb, 'a');
    }

    public function it_starts_with_wildcard_when_using_ends_with_in_context(
        QueryBuilder $qb,
        ArrayCollection $parameters
    ): void {
        $this->beConstructedWith($this->field, $this->value, Like::ENDS_WITH, 'user');

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(1);

        $qb->setParameter('comparison_1', '%bar')->shouldBeCalled();

        $qb->getDQLPart('join')->willReturn([]);
        $qb->getAllAliases()->willReturn([]);
        $qb->join('root.user', 'user')->willReturn($qb);

        $this->getFilter($qb, 'root');
    }

    public function it_ends_with_wildcard_when_using_starts_with(QueryBuilder $qb, ArrayCollection $parameters): void
    {
        $this->beConstructedWith($this->field, $this->value, Like::STARTS_WITH, null);
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(1);

        $qb->setParameter('comparison_1', 'bar%')->shouldBeCalled();

        $this->getFilter($qb, 'a');
    }

    public function it_ends_with_wildcard_when_using_starts_with_in_context(
        QueryBuilder $qb,
        ArrayCollection $parameters
    ): void {
        $this->beConstructedWith($this->field, $this->value, Like::STARTS_WITH, 'user');

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(1);

        $qb->setParameter('comparison_1', 'bar%')->shouldBeCalled();

        $qb->getDQLPart('join')->willReturn([]);
        $qb->getAllAliases()->willReturn([]);
        $qb->join('root.user', 'user')->willReturn($qb);

        $this->getFilter($qb, 'root');
    }

    public function it_filter_array_collection_starts_with(): void
    {
        $this->beConstructedWith('pseudo', 'M', Like::STARTS_WITH, null);

        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001],
        ];

        $this->filterCollection($players)->shouldYield([$players[1]]);
    }

    public function it_filter_array_collection_ends_with(): void
    {
        $this->beConstructedWith('pseudo', 'oe', Like::ENDS_WITH, null);

        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001],
        ];

        $this->filterCollection($players)->shouldYield([$players[0], $players[1]]);
    }

    public function it_filter_array_collection_contains(): void
    {
        $this->beConstructedWith('pseudo', 'o', Like::CONTAINS, null);

        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001],
        ];

        $this->filterCollection($players)->shouldYield([$players[0], $players[1]]);
    }

    public function it_filter_object_collection_starts_with(): void
    {
        $this->beConstructedWith('pseudo', 'M', Like::STARTS_WITH, null);

        $players = [
            new Player('Joe', 'M', 2500),
            new Player('Moe', 'M', 1230),
            new Player('Alice', 'F', 9001),
        ];

        $this->filterCollection($players)->shouldYield([$players[1]]);
    }

    public function it_filter_object_collection_ends_with(): void
    {
        $this->beConstructedWith('pseudo', 'oe', Like::ENDS_WITH, null);

        $players = [
            new Player('Joe', 'M', 2500),
            new Player('Moe', 'M', 1230),
            new Player('Alice', 'F', 9001),
        ];

        $this->filterCollection($players)->shouldYield([$players[0], $players[1]]);
    }

    public function it_filter_object_collection_contains(): void
    {
        $this->beConstructedWith('pseudo', 'o', Like::CONTAINS, null);

        $players = [
            new Player('Joe', 'M', 2500),
            new Player('Moe', 'M', 1230),
            new Player('Alice', 'F', 9001),
        ];

        $this->filterCollection($players)->shouldYield([$players[0], $players[1]]);
    }

    public function it_is_satisfied_with_array_starts_with(): void
    {
        $this->beConstructedWith('pseudo', 'A', Like::STARTS_WITH, null);

        $playerA = ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500];
        $playerB = ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001];

        $this->isSatisfiedBy($playerA)->shouldBe(false);
        $this->isSatisfiedBy($playerB)->shouldBe(true);
    }

    public function it_is_satisfied_with_array_ends_with(): void
    {
        $this->beConstructedWith('pseudo', 'oe', Like::ENDS_WITH, null);

        $playerA = ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500];
        $playerB = ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001];

        $this->isSatisfiedBy($playerA)->shouldBe(true);
        $this->isSatisfiedBy($playerB)->shouldBe(false);
    }

    public function it_is_satisfied_with_array_contains(): void
    {
        $this->beConstructedWith('pseudo', 'oe', Like::CONTAINS, null);

        $playerA = ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500];
        $playerB = ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001];

        $this->isSatisfiedBy($playerA)->shouldBe(true);
        $this->isSatisfiedBy($playerB)->shouldBe(false);
    }

    public function it_is_satisfied_with_object_starts_with(): void
    {
        $this->beConstructedWith('pseudo', 'A', Like::STARTS_WITH, null);

        $playerA = new Player('Joe', 'M', 2500);
        $playerB = new Player('Alice', 'F', 9001);

        $this->isSatisfiedBy($playerA)->shouldBe(false);
        $this->isSatisfiedBy($playerB)->shouldBe(true);
    }

    public function it_is_satisfied_with_object_ends_with(): void
    {
        $this->beConstructedWith('pseudo', 'oe', Like::ENDS_WITH, null);

        $playerA = new Player('Joe', 'M', 2500);
        $playerB = new Player('Alice', 'F', 9001);

        $this->isSatisfiedBy($playerA)->shouldBe(true);
        $this->isSatisfiedBy($playerB)->shouldBe(false);
    }

    public function it_is_satisfied_with_object_contains(): void
    {
        $this->beConstructedWith('pseudo', 'oe', Like::CONTAINS, null);

        $playerA = new Player('Joe', 'M', 2500);
        $playerB = new Player('Alice', 'F', 9001);

        $this->isSatisfiedBy($playerA)->shouldBe(true);
        $this->isSatisfiedBy($playerB)->shouldBe(false);
    }

    public function it_is_satisfied_in_context_with_array_contains(): void
    {
        $game = ['name' => 'Tetris'];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->beConstructedWith('name', 'tr', Like::CONTAINS, 'inGame');

        $this->isSatisfiedBy($player)->shouldBe(true);
    }

    public function it_is_satisfied_in_context_with_object_contains(): void
    {
        $game = new Game('Tetris');
        $player = new Player('Moe', 'M', 1230, $game);

        $this->beConstructedWith('name', 'tr', Like::CONTAINS, 'inGame');

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

        $this->beConstructedWith('name', 'tr', Like::CONTAINS, 'inGame');

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

        $this->beConstructedWith('name', 'tr', Like::CONTAINS, null);

        $this->filterCollection($players, 'inGame')->shouldYield([$players[2]]);
    }

    public function it_is_satisfied_in_global_context(): void
    {
        $game = ['name' => 'Tetris'];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->beConstructedWith('name', 'tr', Like::CONTAINS, null);

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

        $this->beConstructedWith('name', 'BC', Like::CONTAINS, 'owner');

        $this->filterCollection($players, 'inGame')->shouldYield([$players[2]]);
    }

    public function it_is_satisfied_in_combo_context(): void
    {
        $owner = ['name' => 'ABC', 'based' => 123];
        $game = ['name' => 'Tetris', 'owner' => $owner];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->beConstructedWith('name', 'BC', Like::CONTAINS, 'owner');

        $this->isSatisfiedBy($player, 'inGame')->shouldBe(true);
    }
}
