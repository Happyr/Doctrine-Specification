<?php

namespace tests\Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Happyr\DoctrineSpecification\Result\AsArray;
use Happyr\DoctrineSpecification\Specification\Specification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin AsArray
 */
class AsArraySpec extends ObjectBehavior
{
    function it_is_a_result_modifier()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Result\ResultModifier');
    }

    function it_sets_hydration_mode_to_array(AbstractQuery $query)
    {
        $query->setHydrationMode(Query::HYDRATE_ARRAY)->shouldBeCalled();

        $this->modify($query);
    }
}
