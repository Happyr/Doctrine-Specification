<?php

namespace tests\Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Query\AddSelect;
use PhpSpec\ObjectBehavior;

/**
 * @mixin AddSelect
 */
class AddSelectSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('foo');
    }

    public function it_is_a_add_select()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Query\AddSelect');
    }

    public function it_is_a_specification()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Query\QueryModifier');
    }

    public function it_add_select_single_filed(QueryBuilder $qb)
    {
        $qb->addSelect(['a.foo'])->shouldBeCalled();
        $this->modify($qb, 'a');
    }

    public function it_add_select_several_fields(QueryBuilder $qb)
    {
        $this->beConstructedWith('foo', 'bar');
        $qb->addSelect(['b.foo', 'b.bar'])->shouldBeCalled();
        $this->modify($qb, 'b');
    }

    public function it_add_select_several_fields_as_array(QueryBuilder $qb)
    {
        $this->beConstructedWith(['foo', 'bar']);
        $qb->addSelect(['b.foo', 'b.bar'])->shouldBeCalled();
        $this->modify($qb, 'b');
    }

    public function it_add_select_operand(QueryBuilder $qb)
    {
        $this->beConstructedWith('foo', new Field('bar'));
        $qb->addSelect(['b.foo', 'b.bar'])->shouldBeCalled();
        $this->modify($qb, 'b');
    }
}
