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
use Happyr\DoctrineSpecification\Operand\Operand;
use Happyr\DoctrineSpecification\Operand\Value;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Value
 */
final class ValueSpec extends ObjectBehavior
{
    private $value = 'foo';

    private $valueType;

    public function let(): void
    {
        $this->beConstructedWith($this->value, $this->valueType);
    }

    public function it_is_a_value(): void
    {
        $this->shouldBeAnInstanceOf(Value::class);
    }

    public function it_is_a_operand(): void
    {
        $this->shouldBeAnInstanceOf(Operand::class);
    }

    public function it_is_transformable(QueryBuilder $qb, ArrayCollection $parameters): void
    {
        $context = 'a';

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', $this->value, $this->valueType)->shouldBeCalled();

        $this->transform($qb, $context)->shouldReturn(':comparison_10');
    }

    public function it_is_transformable_dbal_type(QueryBuilder $qb, ArrayCollection $parameters): void
    {
        $valueType = 'date';
        $this->beConstructedWith($this->value, $valueType);

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', $this->value, $valueType)->shouldBeCalled();

        $this->transform($qb, 'a')->shouldReturn(':comparison_10');
    }

    public function it_is_transformable_pdo_type(QueryBuilder $qb, ArrayCollection $parameters): void
    {
        $valueType = \PDO::PARAM_INT;
        $this->beConstructedWith($this->value, $valueType);

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', $this->value, $valueType)->shouldBeCalled();

        $this->transform($qb, 'a')->shouldReturn(':comparison_10');
    }

    public function it_is_executable(): void
    {
        $candidate = null; // not used

        $this->execute($candidate)->shouldReturn($this->value);
    }
}
