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

namespace tests\Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Operand\Operand;
use PhpSpec\ObjectBehavior;
use Symfony\Component\PropertyAccess\Exception\NoSuchIndexException;
use tests\Happyr\DoctrineSpecification\Game;
use tests\Happyr\DoctrineSpecification\Player;

/**
 * @mixin Field
 */
final class FieldSpec extends ObjectBehavior
{
    private $fieldName = 'foo';

    public function let(): void
    {
        $this->beConstructedWith($this->fieldName, null);
    }

    public function it_is_a_field(): void
    {
        $this->shouldBeAnInstanceOf(Field::class);
    }

    public function it_is_a_operand(): void
    {
        $this->shouldBeAnInstanceOf(Operand::class);
    }

    public function it_is_transformable(QueryBuilder $qb): void
    {
        $context = 'a';
        $expression = 'a.foo';

        $this->transform($qb, $context)->shouldReturn($expression);
    }

    public function it_is_in_context(QueryBuilder $qb): void
    {
        $this->beConstructedWith($this->fieldName, 'user');

        $qb->getDQLPart('join')->willReturn([]);
        $qb->getAllAliases()->willReturn([]);
        $qb->join('root.user', 'user')->willReturn($qb);

        $this->transform($qb, 'root')->shouldReturn(sprintf('user.%s', $this->fieldName));
    }

    public function it_is_executable_object(): void
    {
        $this->beConstructedWith('pseudo');

        $player = new Player('Moe', 'M', 1230);

        $this->execute($player)->shouldReturn($player->pseudo);
    }

    public function it_is_executable_array(): void
    {
        $this->beConstructedWith('pseudo');

        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230];

        $this->execute($player)->shouldReturn($player['pseudo']);
    }

    public function it_is_executable_object_in_context(): void
    {
        $this->beConstructedWith('name', 'inGame');

        $game = new Game('Tetris');
        $player = new Player('Moe', 'M', 1230, $game);

        $this->execute($player)->shouldReturn($game->name);
    }

    public function it_is_executable_array_in_context(): void
    {
        $this->beConstructedWith('name', 'inGame');

        $game = ['name' => 'Tetris'];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->execute($player)->shouldReturn($game['name']);
    }

    public function it_is_executable_object_in_global_context(): void
    {
        $this->beConstructedWith('name');

        $game = new Game('Tetris');
        $player = new Player('Moe', 'M', 1230, $game);

        $this->execute($player, 'inGame')->shouldReturn($game->name);
    }

    public function it_is_executable_array_in_global_context(): void
    {
        $this->beConstructedWith('name');

        $game = ['name' => 'Tetris'];
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->execute($player, 'inGame')->shouldReturn($game['name']);
    }

    public function it_is_executable_mixed_candidate(): void
    {
        $this->beConstructedWith('name', 'inGame');

        $game = new Game('Tetris');
        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230, 'inGame' => $game];

        $this->shouldThrow(NoSuchIndexException::class)->duringExecute($player);
    }

    public function it_is_executable_collection(): void
    {
        $this->beConstructedWith('pseudo', 'players');

        $game = [
            'name' => 'Tetris',
            'players' => [
                ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230],
            ],
        ];

        $this->execute($game)->shouldReturn(null);
    }
}
