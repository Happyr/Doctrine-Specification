<?php

namespace tests\Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\Alias;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Alias
 */
class AliasSpec extends ObjectBehavior
{
    private $alias = 'foo';

    public function let()
    {
        $this->beConstructedWith($this->alias);
    }

    public function it_is_a_alias()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Operand\Alias');
    }

    public function it_is_a_operand()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Operand\Operand');
    }

    public function it_is_transformable(QueryBuilder $qb)
    {
        $this->transform($qb, 'a')->shouldReturn($this->alias);
    }
}
