<?php

namespace tests\Happyr\DoctrineSpecification\ResultModifier;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Happyr\DoctrineSpecification\ResultModifier\AsArray;
use PhpSpec\ObjectBehavior;

/**
 * @mixin AsArray
 */
class AsArraySpec extends ObjectBehavior
{
    public function it_is_a_result_modifier()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\ResultModifier\ResultModifier');
    }

    public function it_sets_hydration_mode_to_array(AbstractQuery $query)
    {
        $query->setHydrationMode(Query::HYDRATE_ARRAY)->shouldBeCalled();

        $this->modify($query);
    }
}
