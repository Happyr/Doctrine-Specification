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
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\Operand;
use Happyr\DoctrineSpecification\Operand\Values;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Values
 */
class ValuesSpec extends ObjectBehavior
{
    private $values = ['foo', 'bar'];

    private $valueType;

    public function let()
    {
        $this->beConstructedWith($this->values, $this->valueType);
    }

    public function it_is_a_values()
    {
        $this->shouldBeAnInstanceOf(Values::class);
    }

    public function it_is_a_operand()
    {
        $this->shouldBeAnInstanceOf(Operand::class);
    }

    public function it_is_transformable(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $dqlAlias = 'a';

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', $this->values, $this->valueType)->shouldBeCalled();

        $this->transform($qb, $dqlAlias)->shouldReturn(':comparison_10');
    }

    public function it_is_transformable_dbal_type(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $valueType = Type::DATE;
        $this->beConstructedWith($this->values, $valueType);

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', $this->values, $valueType)->shouldBeCalled();

        $this->transform($qb, 'a')->shouldReturn(':comparison_10');
    }

    public function it_is_transformable_pdo_type(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $valueType = \PDO::PARAM_INT;
        $this->beConstructedWith($this->values, $valueType);

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', $this->values, $valueType)->shouldBeCalled();

        $this->transform($qb, 'a')->shouldReturn(':comparison_10');
    }
}
