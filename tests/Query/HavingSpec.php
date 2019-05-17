<?php

namespace tests\Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\Having;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Having
 */
class HavingSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('foo = :bar');
    }

    public function it_is_a_having()
    {
        $this->shouldBeAnInstanceOf(Having::class);
    }

    public function it_is_a_query_modifier()
    {
        $this->shouldHaveType(QueryModifier::class);
    }

    public function it_add_having(QueryBuilder $qb, Filter $filter)
    {
        $this->beConstructedWith($filter);
        $filter->getFilter($qb, 'a')->willReturn('foo = :bar');
        $qb->having('foo = :bar')->shouldBeCalled();
        $this->modify($qb, 'a');
    }
}
