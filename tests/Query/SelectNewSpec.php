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

namespace tests\Happyr\DoctrineSpecification\Query;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\Addition;
use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Operand\Value;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Query\SelectNew;
use PhpSpec\ObjectBehavior;
use tests\Happyr\DoctrineSpecification\Player;

/**
 * @mixin SelectNew
 */
final class SelectNewSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(Player::class);
    }

    public function it_is_a_select_new(): void
    {
        $this->shouldBeAnInstanceOf(SelectNew::class);
    }

    public function it_is_a_query_modifier(): void
    {
        $this->shouldHaveType(QueryModifier::class);
    }

    public function it_select_empty_object(QueryBuilder $qb): void
    {
        $qb->select(sprintf('NEW %s()', Player::class))->shouldBeCalled();

        $this->modify($qb, 'a');
    }

    public function it_select_with_field(QueryBuilder $qb): void
    {
        $this->beConstructedWith(Player::class, 'pseudo');

        $qb->select(sprintf('NEW %s(a.pseudo)', Player::class))->shouldBeCalled();

        $this->modify($qb, 'a');
    }

    public function it_select_with_field_and_value(QueryBuilder $qb, ArrayCollection $parameters): void
    {
        $this->beConstructedWith(Player::class, 'pseudo', 'F');

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 'F', null)->shouldBeCalled();
        $qb->select(sprintf('NEW %s(a.pseudo, :comparison_10)', Player::class))->shouldBeCalled();

        $this->modify($qb, 'a');
    }

    public function it_select_with_operands(QueryBuilder $qb, ArrayCollection $parameters): void
    {
        $this->beConstructedWith(
            Player::class,
            new Field('pseudo'),
            new Value('F'),
            new Addition(new Field('foo'), new Field('bar'))
        );

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 'F', null)->shouldBeCalled();
        $qb->select(sprintf('NEW %s(a.pseudo, :comparison_10, (a.foo + a.bar))', Player::class))->shouldBeCalled();

        $this->modify($qb, 'a');
    }
}
