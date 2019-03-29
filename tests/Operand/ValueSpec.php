<?php

namespace tests\Happyr\DoctrineSpecification\Operand;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\Value;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Value
 */
class ValueSpec extends ObjectBehavior
{
    private $value = 'foo';

    private $valueType = null;

    public function let()
    {
        $this->beConstructedWith($this->value, $this->valueType);
    }

    public function it_is_a_value()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Operand\Value');
    }

    public function it_is_a_operand()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Operand\Operand');
    }

    public function it_is_transformable(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $dqlAlias = 'a';

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', $this->value, $this->valueType)->shouldBeCalled();

        $this->transform($qb, $dqlAlias)->shouldReturn(':comparison_10');
    }

    public function it_is_transformable_dbal_type(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $valueType = Type::DATE;
        $this->beConstructedWith($this->value, $valueType);

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', $this->value, $valueType)->shouldBeCalled();

        $this->transform($qb, 'a')->shouldReturn(':comparison_10');
    }

    public function it_is_transformable_pdo_type(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $valueType = \PDO::PARAM_INT;
        $this->beConstructedWith($this->value, $valueType);

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', $this->value, $valueType)->shouldBeCalled();

        $this->transform($qb, 'a')->shouldReturn(':comparison_10');
    }
}
