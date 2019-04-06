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

    public function it_create_bit_and_operand()
    {
        $this->bAnd('foo', 'bar')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Operand\BitAnd');
    }

    public function it_create_bit_or_operand()
    {
        $this->bOr('foo', 'bar')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Operand\BitOr');
    }

    public function it_create_bit_xor_operand()
    {
        $this->bXor('foo', 'bar')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Operand\BitXor');
    }

    public function it_create_bit_left_shift_operand()
    {
        $this->bLs('foo', 'bar')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Operand\BitLeftShift');
    }

    public function it_create_bit_right_shift_operand()
    {
        $this->bRs('foo', 'bar')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Operand\BitRightShift');
    }

    public function it_create_bit_not_operand()
    {
        $this->bNot('foo')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Operand\BitNot');
    }
}
