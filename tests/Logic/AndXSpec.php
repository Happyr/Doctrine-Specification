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
use Happyr\DoctrineSpecification\Filter\GreaterThan;
use Happyr\DoctrineSpecification\Filter\LessThan;
use Happyr\DoctrineSpecification\Logic\AndX;
use Happyr\DoctrineSpecification\Specification\Specification;
use PhpSpec\ObjectBehavior;
use tests\Happyr\DoctrineSpecification\Game;
use tests\Happyr\DoctrineSpecification\Player;

/**
 * @mixin AndX
 */
final class AndXSpec extends ObjectBehavior
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
        $context = 'a';

        $specificationA->modify($queryBuilder, $context)->shouldBeCalled();
        $specificationB->modify($queryBuilder, $context)->shouldBeCalled();

        $this->modify($queryBuilder, $context);
    }

    public function it_composes_and_child_with_expression(
        QueryBuilder $qb,
        Expr $expression,
        Specification $specificationA,
        Specification $specificationB
    ): void {
        $filterA = 'foo';
        $filterB = 'bar';
        $context = 'a';

        $specificationA->getFilter($qb, $context)->willReturn($filterA);
        $specificationB->getFilter($qb, $context)->willReturn($filterB);
        $qb->expr()->willReturn($expression);

        $expression->andX($filterA, $filterB)->shouldBeCalled();

        $this->getFilter($qb, $context);
    }

    public function it_supports_expressions(QueryBuilder $qb, Expr $expression, Filter $exprA, Filter $exprB): void
    {
        $this->beConstructedWith($exprA, $exprB);

        $filterA = 'foo';
        $filterB = 'bar';
        $context = 'a';

        $exprA->getFilter($qb, $context)->willReturn($filterA);
        $exprB->getFilter($qb, $context)->willReturn($filterB);
        $qb->expr()->willReturn($expression);

        $expression->andX($filterA, $filterB)->shouldBeCalled();

        $this->getFilter($qb, $context);
    }

    public function it_filter_array_collection(): void
    {
        $this->beConstructedWith(
            new Equals('gender', 'F'),
            new GreaterThan('points', 9000)
        );

        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001],
        ];

        $this->filterCollection($players)->shouldYield([$players[2]]);
    }

    public function it_filter_object_collection(): void
    {
        $this->beConstructedWith(
            new Equals('gender', 'F'),
            new GreaterThan('points', 9000)
        );

        $players = [
            new Player('Joe', 'M', 2500),
            new Player('Moe', 'M', 1230),
            new Player('Alice', 'F', 9001),
        ];

        $this->filterCollection($players)->shouldYield([$players[2]]);
    }

    public function it_filter_array_collection_not_satisfiable(Filter $exprA, Filter $exprB): void
    {
        $this->beConstructedWith($exprA, $exprB);

        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001],
        ];

        $this->filterCollection($players)->shouldNotYield([]);
    }

    public function it_filter_object_collection_not_satisfiable(Filter $exprA, Filter $exprB): void
    {
        $this->beConstructedWith($exprA, $exprB);

        $players = [
            new Player('Joe', 'M', 2500),
            new Player('Moe', 'M', 1230),
            new Player('Alice', 'F', 9001),
        ];

        $this->filterCollection($players)->shouldNotYield([]);
    }

    public function it_is_satisfied_with_array(): void
    {
        $this->beConstructedWith(
            new Equals('gender', 'F'),
            new GreaterThan('points', 9000)
        );

        $playerA = ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500];
        $playerB = ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001];

        $this->isSatisfiedBy($playerA)->shouldBe(false);
        $this->isSatisfiedBy($playerB)->shouldBe(true);
    }

    public function it_is_satisfied_with_object(): void
    {
        $this->beConstructedWith(
            new Equals('gender', 'F'),
            new GreaterThan('points', 9000)
        );

        $playerA = new Player('Joe', 'M', 2500);
        $playerB = new Player('Alice', 'F', 9001);

        $this->isSatisfiedBy($playerA)->shouldBe(false);
        $this->isSatisfiedBy($playerB)->shouldBe(true);
    }

    public function it_is_satisfied_with_array_not_satisfiable(Filter $exprA, Filter $exprB): void
    {
        $this->beConstructedWith($exprA, $exprB);

        $player = ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001];

        $this->isSatisfiedBy($player)->shouldBe(true);
    }

    public function it_is_satisfied_with_object_not_satisfiable(Filter $exprA, Filter $exprB): void
    {
        $this->beConstructedWith($exprA, $exprB);

        $player = new Player('Alice', 'F', 9001);

        $this->isSatisfiedBy($player)->shouldBe(true);
    }

    public function it_filter_array_collection_in_context(): void
    {
        $this->beConstructedWith(new Equals('name', 'Tetris'), new LessThan('releaseAt', new \DateTimeImmutable()));

        $releaseAt = new \DateTimeImmutable('-1 day');
        $game = ['name' => 'Tetris', 'releaseAt' => $releaseAt];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->filterCollection([$player], 'inGame')->shouldYield([$player]);
    }

    public function it_filter_object_collection_in_context(): void
    {
        $this->beConstructedWith(new Equals('name', 'Tetris'), new LessThan('releaseAt', new \DateTimeImmutable()));

        $releaseAt = new \DateTimeImmutable('-1 day');
        $game = new Game('Tetris', $releaseAt);
        $player = new Player('Moe', 'M', 1230, $game);

        $this->filterCollection([$player], 'inGame')->shouldYield([$player]);
    }

    public function it_is_satisfied_array_collection_in_context(): void
    {
        $this->beConstructedWith(new Equals('name', 'Tetris'), new LessThan('releaseAt', new \DateTimeImmutable()));

        $releaseAt = new \DateTimeImmutable('-1 day');
        $game = ['name' => 'Tetris', 'releaseAt' => $releaseAt];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->isSatisfiedBy($player, 'inGame')->shouldBe(true);
    }

    public function it_is_satisfied_object_collection_in_context(): void
    {
        $this->beConstructedWith(new Equals('name', 'Tetris'), new LessThan('releaseAt', new \DateTimeImmutable()));

        $releaseAt = new \DateTimeImmutable('-1 day');
        $game = new Game('Tetris', $releaseAt);
        $player = new Player('Moe', 'M', 1230, $game);

        $this->isSatisfiedBy($player, 'inGame')->shouldBe(true);
    }
}
