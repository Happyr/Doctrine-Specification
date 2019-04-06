<?php

namespace tests\Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Spec;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Spec
 */
class SpecSpec extends ObjectBehavior
{
    public function it_creates_an_x_specification()
    {
        $this->andX()->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Logic\LogicX');
    }

    public function it_creates_add_operand()
    {
        $this->add('foo', 'bar')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Operand\Add');
    }

    public function it_creates_sub_operand()
    {
        $this->sub('foo', 'bar')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Operand\Sub');
    }

    public function it_creates_mul_operand()
    {
        $this->mul('foo', 'bar')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Operand\Mul');
    }

    public function it_creates_div_operand()
    {
        $this->div('foo', 'bar')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Operand\Div');
    }

    public function it_creates_mod_operand()
    {
        $this->mod('foo', 'bar')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Operand\Mod');
    }
}
