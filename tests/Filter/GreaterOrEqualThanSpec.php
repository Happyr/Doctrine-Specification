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
use Happyr\DoctrineSpecification\Filter\GreaterOrEqualThan;
use PhpSpec\ObjectBehavior;
use tests\Happyr\DoctrineSpecification\Game;
use tests\Happyr\DoctrineSpecification\Player;

/**
 * @mixin GreaterOrEqualThan
 */
final class GreaterOrEqualThanSpec extends ObjectBehavior
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

        $comparison->shouldReturn('a.age >= :comparison_10');
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

        $this->getFilter($qb, 'root')->shouldReturn('user.age >= :comparison_10');
    }

    public function it_filter_array_collection(): void
    {
        $this->beConstructedWith('points', 9000, null);

        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9000],
        ];

        $this->filterCollection($players)->shouldYield([$players[2]]);
    }

    public function it_filter_object_collection(): void
    {
        $this->beConstructedWith('points', 9000, null);

        $players = [
            new Player('Joe', 'M', 2500),
            new Player('Moe', 'M', 1230),
            new Player('Alice', 'F', 9000),
        ];

        $this->filterCollection($players)->shouldYield([$players[2]]);
    }

    public function it_is_satisfied_with_array(): void
    {
        $this->beConstructedWith('points', 2500, null);

        $playerA = ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500];
        $playerB = ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230];
        $playerC = ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001];

        $this->isSatisfiedBy($playerA)->shouldBe(true);
        $this->isSatisfiedBy($playerB)->shouldBe(false);
        $this->isSatisfiedBy($playerC)->shouldBe(true);
    }

    public function it_is_satisfied_with_object(): void
    {
        $this->beConstructedWith('points', 2500, null);

        $playerA = new Player('Joe', 'M', 2500);
        $playerB = new Player('Moe', 'M', 1230);
        $playerC = new Player('Alice', 'F', 9001);

        $this->isSatisfiedBy($playerA)->shouldBe(true);
        $this->isSatisfiedBy($playerB)->shouldBe(false);
        $this->isSatisfiedBy($playerC)->shouldBe(true);
    }

    public function it_is_satisfied_in_context_with_array(): void
    {
        $releaseAt = new \DateTimeImmutable();
        $game = ['name' => 'Tetris', 'releaseAt' => $releaseAt];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->beConstructedWith('releaseAt', $releaseAt, 'inGame');

        $this->isSatisfiedBy($player)->shouldBe(true);
    }

    public function it_is_satisfied_in_context_with_object(): void
    {
        $releaseAt = new \DateTimeImmutable();
        $game = new Game('Tetris', $releaseAt);
        $player = new Player('Moe', 'M', 1230, $game);

        $this->beConstructedWith('releaseAt', $releaseAt, 'inGame');

        $this->isSatisfiedBy($player)->shouldBe(true);
    }

    public function it_filter_array_collection_in_context(): void
    {
        $releaseAt = new \DateTimeImmutable();
        $game = ['name' => 'Tetris', 'releaseAt' => $releaseAt];
        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001, 'inGame' => $game],
        ];

        $this->beConstructedWith('releaseAt', $releaseAt, 'inGame');

        $this->filterCollection($players)->shouldYield([$players[2]]);
    }

    public function it_filter_array_collection_in_global_context(): void
    {
        $releaseAt = new \DateTimeImmutable();
        $game = ['name' => 'Tetris', 'releaseAt' => $releaseAt];
        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001, 'inGame' => $game],
        ];

        $this->beConstructedWith('releaseAt', $releaseAt, null);

        $this->filterCollection($players, 'inGame')->shouldYield([$players[2]]);
    }

    public function it_is_satisfied_in_global_context(): void
    {
        $releaseAt = new \DateTimeImmutable();
        $game = ['name' => 'Tetris', 'releaseAt' => $releaseAt];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->beConstructedWith('releaseAt', $releaseAt, null);

        $this->isSatisfiedBy($player, 'inGame')->shouldBe(true);
    }

    public function it_filter_array_collection_in_combo_context(): void
    {
        $owner = ['name' => 'ABC', 'based' => 123];
        $game = ['name' => 'Tetris', 'owner' => $owner];
        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001, 'inGame' => $game],
        ];

        $this->beConstructedWith('based', 123, 'owner');

        $this->filterCollection($players, 'inGame')->shouldYield([$players[2]]);
    }

    public function it_is_satisfied_in_combo_context(): void
    {
        $owner = ['name' => 'ABC', 'based' => 123];
        $game = ['name' => 'Tetris', 'owner' => $owner];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->beConstructedWith('based', 123, 'owner');

        $this->isSatisfiedBy($player, 'inGame')->shouldBe(true);
    }
}
