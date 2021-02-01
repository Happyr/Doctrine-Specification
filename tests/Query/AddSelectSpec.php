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

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Query\AddSelect;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use PhpSpec\ObjectBehavior;

/**
 * @mixin AddSelect
 */
final class AddSelectSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('foo');
    }

    public function it_is_a_add_select(): void
    {
        $this->shouldBeAnInstanceOf(AddSelect::class);
    }

    public function it_is_a_query_modifier(): void
    {
        $this->shouldHaveType(QueryModifier::class);
    }

    public function it_add_select_single_filed(QueryBuilder $qb): void
    {
        $qb->addSelect(['a.foo'])->shouldBeCalled();
        $this->modify($qb, 'a');
    }

    public function it_add_select_several_fields(QueryBuilder $qb): void
    {
        $this->beConstructedWith('foo', 'bar');
        $qb->addSelect(['b.foo', 'b.bar'])->shouldBeCalled();
        $this->modify($qb, 'b');
    }

    public function it_add_select_operand(QueryBuilder $qb): void
    {
        $this->beConstructedWith('foo', new Field('bar'));
        $qb->addSelect(['b.foo', 'b.bar'])->shouldBeCalled();
        $this->modify($qb, 'b');
    }
}
