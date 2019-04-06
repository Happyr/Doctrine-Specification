<?php

namespace tests\Happyr\DoctrineSpecification\Operand;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\Mul;
use Happyr\DoctrineSpecification\Operand\Field;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Mul
 */
class MulSpec extends ObjectBehavior
{
    private $field = 'foo';

    private $value = 'bar';

    public function let()
    {
        $this->beConstructedWith($this->field, $this->value);
    }

    public function it_is_a_mul()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Operand\Mul');
    }

    public function it_is_a_operand()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Operand\Operand');
    }

    public function it_is_transformable(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', $this->value, null)->shouldBeCalled();

        $this->transform($qb, 'a')->shouldReturn('(a.foo * :comparison_10)');
    }

    public function it_is_transformable_add_fields(QueryBuilder $qb)
    {
        $this->beConstructedWith(new Field('foo'), new Field('bar'));
        $this->transform($qb, 'a')->shouldReturn('(a.foo * a.bar)');
    }
}
