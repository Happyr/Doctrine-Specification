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
use Doctrine\ORM\Query\Expr\Comparison;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Filter\InstanceOfX;
use PhpSpec\ObjectBehavior;
use tests\Happyr\DoctrineSpecification\Game;
use tests\Happyr\DoctrineSpecification\Player;

/**
 * @mixin InstanceOfX
 */
final class InstanceOfXSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('My\Model', null);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(InstanceOfX::class);
    }

    public function it_is_an_expression(): void
    {
        $this->shouldBeAnInstanceOf(Filter::class);
    }

    public function it_returns_expression_func_object(QueryBuilder $qb, Expr $exp): void
    {
        $exp_comparison = new Comparison('o', 'INSTANCE OF', 'My\Model');
        $exp->isInstanceOf('o', 'My\Model')->willReturn($exp_comparison);

        $qb->expr()->willReturn($exp);

        $this->getFilter($qb, 'o')->shouldReturn('o INSTANCE OF My\Model');
    }

    public function it_returns_expression_func_object_in_context(QueryBuilder $qb, Expr $exp): void
    {
        $this->beConstructedWith('My\Model', 'o');

        $exp_comparison = new Comparison('o', 'INSTANCE OF', 'My\Model');
        $exp->isInstanceOf('o', 'My\Model')->willReturn($exp_comparison);

        $qb->expr()->willReturn($exp);

        $qb->getDQLPart('join')->willReturn([]);
        $qb->getAllAliases()->willReturn([]);
        $qb->join('root.o', 'o')->willReturn($qb);

        $this->getFilter($qb, 'root')->shouldReturn('o INSTANCE OF My\Model');
    }

    public function it_filter_array_collection(): void
    {
        $this->beConstructedWith(Player::class, null);

        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001],
        ];

        $this->filterCollection($players)->shouldYield([]);
    }

    public function it_filter_object_collection(): void
    {
        $this->beConstructedWith(Player::class, null);

        $players = [
            new Player('Joe', 'M', 2500),
            new Player('Moe', 'M', 1230),
            new Player('Alice', 'F', 9001),
        ];

        $this->filterCollection($players)->shouldYield([$players[0], $players[1], $players[2]]);
    }

    public function it_is_satisfied_with_array(): void
    {
        $this->beConstructedWith(Player::class, null);

        $player = ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001];

        $this->isSatisfiedBy($player)->shouldBe(false);
    }

    public function it_is_satisfied_with_object(): void
    {
        $this->beConstructedWith(Player::class, null);

        $player = new Player('Alice', 'F', 9001);

        $this->isSatisfiedBy($player)->shouldBe(true);
    }

    public function it_is_satisfied_in_context_with_array(): void
    {
        $game = ['name' => 'Tetris'];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->beConstructedWith(Player::class, 'inGame');

        $this->isSatisfiedBy($player)->shouldBe(false);
    }

    public function it_is_satisfied_in_context_with_object(): void
    {
        $game = new Game('Tetris');
        $player = new Player('Moe', 'M', 1230, $game);

        $this->beConstructedWith(Player::class, 'inGame');

        $this->isSatisfiedBy($player)->shouldBe(true);
    }
}
