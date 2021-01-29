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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Operand\Multiplication;
use Happyr\DoctrineSpecification\Operand\Operand;
use Happyr\DoctrineSpecification\Operand\Value;
use PhpSpec\ObjectBehavior;
use tests\Happyr\DoctrineSpecification\Player;

/**
 * @mixin Multiplication
 */
final class MultiplicationSpec extends ObjectBehavior
{
    private $field = 'foo';

    private $value = 'bar';

    public function let(): void
    {
        $this->beConstructedWith($this->field, $this->value);
    }

    public function it_is_a_mul(): void
    {
        $this->shouldBeAnInstanceOf(Multiplication::class);
    }

    public function it_is_a_operand(): void
    {
        $this->shouldBeAnInstanceOf(Operand::class);
    }

    public function it_is_transformable(QueryBuilder $qb, ArrayCollection $parameters): void
    {
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', $this->value, null)->shouldBeCalled();

        $this->transform($qb, 'a')->shouldReturn('(a.foo * :comparison_10)');
    }

    public function it_is_transformable_add_fields(QueryBuilder $qb): void
    {
        $this->beConstructedWith(new Field('foo'), new Field('bar'));
        $this->transform($qb, 'a')->shouldReturn('(a.foo * a.bar)');
    }

    public function it_is_executable_object(): void
    {
        $this->beConstructedWith('points', 100);

        $player = new Player('Moe', 'M', 1230);

        $this->execute($player)->shouldReturn(123000);
    }

    public function it_is_executable_object_with_operands(): void
    {
        $this->beConstructedWith(new Field('points'), new Value(100));

        $player = new Player('Moe', 'M', 1230);

        $this->execute($player)->shouldReturn(123000);
    }

    public function it_is_executable_array(): void
    {
        $this->beConstructedWith('points', 100);

        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230];

        $this->execute($player)->shouldReturn(123000);
    }

    public function it_is_executable_array_with_operands(): void
    {
        $this->beConstructedWith(new Field('points'), new Value(100));

        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230];

        $this->execute($player)->shouldReturn(123000);
    }
}
