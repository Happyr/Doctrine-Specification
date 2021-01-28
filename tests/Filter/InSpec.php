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
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Filter\In;
use PhpSpec\ObjectBehavior;
use tests\Happyr\DoctrineSpecification\Game;
use tests\Happyr\DoctrineSpecification\Player;

/**
 * @mixin In
 */
final class InSpec extends ObjectBehavior
{
    private $field = 'foobar';

    private $value = ['bar', 'baz'];

    public function let(): void
    {
        $this->beConstructedWith($this->field, $this->value, null);
    }

    public function it_is_an_expression(): void
    {
        $this->shouldBeAnInstanceOf(Filter::class);
    }

    public function it_returns_expression_func_object(QueryBuilder $qb, ArrayCollection $parameters, Expr $expr): void
    {
        $context = 'a';
        $qb->expr()->willReturn($expr);
        $expr->in(sprintf('%s.%s', $context, $this->field), ':comparison_10')->shouldBeCalled();

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', $this->value, null)->shouldBeCalled();

        $this->getFilter($qb, 'a');
    }

    public function it_filter_array_collection(): void
    {
        $this->beConstructedWith('points', [1230, 2500], null);

        $players = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001],
        ];

        $this->filterCollection($players)->shouldYield([$players[0], $players[1]]);
    }

    public function it_filter_object_collection(): void
    {
        $this->beConstructedWith('points', [1230, 2500], null);

        $players = [
            new Player('Joe', 'M', 2500),
            new Player('Moe', 'M', 1230),
            new Player('Alice', 'F', 9001),
        ];

        $this->filterCollection($players)->shouldYield([$players[0], $players[1]]);
    }

    public function it_is_satisfied_with_array(): void
    {
        $this->beConstructedWith('points', [1230, 2500], null);

        $playerA = ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500];
        $playerB = ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230];
        $playerC = ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001];

        $this->isSatisfiedBy($playerA)->shouldBe(true);
        $this->isSatisfiedBy($playerB)->shouldBe(true);
        $this->isSatisfiedBy($playerC)->shouldBe(false);
    }

    public function it_is_satisfied_with_object(): void
    {
        $this->beConstructedWith('points', [1230, 2500], null);

        $playerA = new Player('Joe', 'M', 2500);
        $playerB = new Player('Moe', 'M', 1230);
        $playerC = new Player('Alice', 'F', 9001);

        $this->isSatisfiedBy($playerA)->shouldBe(true);
        $this->isSatisfiedBy($playerB)->shouldBe(true);
        $this->isSatisfiedBy($playerC)->shouldBe(false);
    }

    public function it_is_satisfied_in_context_with_array(): void
    {
        $game = ['name' => 'Tetris'];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->beConstructedWith('name', ['Mahjong', 'Tetris'], 'inGame');

        $this->isSatisfiedBy($player)->shouldBe(true);
    }

    public function it_is_satisfied_in_context_with_object(): void
    {
        $game = new Game('Tetris');
        $player = new Player('Moe', 'M', 1230, $game);

        $this->beConstructedWith('name', ['Mahjong', 'Tetris'], 'inGame');

        $this->isSatisfiedBy($player)->shouldBe(true);
    }
}
