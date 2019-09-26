<?php

namespace tests\Happyr\DoctrineSpecification\Operand;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\CountDistinct;
use Happyr\DoctrineSpecification\Operand\Operand;
use PhpSpec\ObjectBehavior;

/**
 * @mixin CountDistinct
 */
class CountDistinctSpec extends ObjectBehavior
{
    private $field = 'foo';

    public function let()
    {
        $this->beConstructedWith($this->field);
    }

    public function it_is_a_count_distinct()
    {
        $this->shouldBeAnInstanceOf(CountDistinct::class);
    }

    public function it_is_a_operand()
    {
        $this->shouldBeAnInstanceOf(Operand::class);
    }

    public function it_is_transformable(QueryBuilder $qb)
    {
        $this->transform($qb, 'a')->shouldReturn('COUNT(DISTINCT a.foo)');
    }
}
