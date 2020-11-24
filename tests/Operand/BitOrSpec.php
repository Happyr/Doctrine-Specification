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
use Happyr\DoctrineSpecification\Operand\BitOr;
use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Operand\Operand;
use PhpSpec\ObjectBehavior;

/**
 * @mixin BitOr
 */
class BitOrSpec extends ObjectBehavior
{
    private $field = 'foo';

    private $value = 'bar';

    public function let()
    {
        $this->beConstructedWith($this->field, $this->value);
    }

    public function it_is_a_bit_or()
    {
        $this->shouldBeAnInstanceOf(BitOr::class);
    }

    public function it_is_a_operand()
    {
        $this->shouldBeAnInstanceOf(Operand::class);
    }

    public function it_is_transformable(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', $this->value, null)->shouldBeCalled();

        $this->transform($qb, 'a')->shouldReturn('BIT_OR(a.foo, :comparison_10)');
    }

    public function it_is_transformable_add_fields(QueryBuilder $qb)
    {
        $this->beConstructedWith(new Field('foo'), new Field('bar'));
        $this->transform($qb, 'a')->shouldReturn('BIT_OR(a.foo, a.bar)');
    }
}
