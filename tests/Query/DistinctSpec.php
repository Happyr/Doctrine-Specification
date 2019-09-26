<?php

namespace tests\Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\Distinct;
use Happyr\DoctrineSpecification\Query\Having;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Distinct
 */
class DistinctSpec extends ObjectBehavior
{
    public function it_is_a_distinct()
    {
        $this->shouldBeAnInstanceOf(Distinct::class);
    }

    public function it_is_a_query_modifier()
    {
        $this->shouldHaveType(QueryModifier::class);
    }

    public function it_add_having(QueryBuilder $qb)
    {
        $qb->distinct()->shouldBeCalled();
        $this->modify($qb, 'a');
    }
}
