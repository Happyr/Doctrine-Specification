<?php

namespace tests\Happyr\DoctrineSpecification\ResultModifier;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Happyr\DoctrineSpecification\ResultModifier\AsSingleScalar;
use PhpSpec\ObjectBehavior;

/**
 * @mixin AsSingleScalar
 */
class AsSingleScalarSpec extends ObjectBehavior
{
    public function it_is_a_result_modifier()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\ResultModifier\ResultModifier');
    }

    public function it_sets_hydration_mode_to_object(AbstractQuery $query)
    {
        $query->setHydrationMode(Query::HYDRATE_SINGLE_SCALAR)->shouldBeCalled();

        $this->modify($query);
    }
}
