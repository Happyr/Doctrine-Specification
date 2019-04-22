<?php

namespace tests\Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\BitNot;
use PhpSpec\ObjectBehavior;

/**
 * @mixin BitNot
 */
class BitNotSpec extends ObjectBehavior
{
    private $field = 'foo';

    public function let()
    {
        $this->beConstructedWith($this->field);
    }

    public function it_is_a_bit_not()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Operand\BitNot');
    }

    public function it_is_a_operand()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Operand\Operand');
    }

    public function it_is_transformable(QueryBuilder $qb)
    {
        $this->transform($qb, 'a')->shouldReturn('(~ a.foo)');
    }
}
