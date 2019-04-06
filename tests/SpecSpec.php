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

    public function it_creates_an_function()
    {
        $this->fun('UPPER', 'foo')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Operand\PlatformFunction');
    }

    public function it_creates_an_magic_function()
    {
        $this->__callStatic('UPPER', ['foo'])->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Operand\PlatformFunction');
    }
}
