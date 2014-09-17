<?php

namespace spec\Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Happyr\DoctrineSpecification\Result\AsArray;
use Happyr\DoctrineSpecification\Specification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin AsArray
 */
class AsArraySpec extends ObjectBehavior
{
    function let(Specification $specification)
    {
        $this->beConstructedWith($specification);
    }

    function it_is_a_result_modifier()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Result\Modifier');
    }

    function it_sets_hydration_mode_to_array(AbstractQuery $query)
    {
        $query->setHydrationMode(Query::HYDRATE_ARRAY)->shouldBeCalled();

        $this->modify($query);
    }
}
