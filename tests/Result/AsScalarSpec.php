<?php

namespace tests\Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Happyr\DoctrineSpecification\Result\AsScalar;
use PhpSpec\ObjectBehavior;

/**
 * @mixin AsScalar
 */
class AsScalarSpec extends ObjectBehavior
{
    public function it_is_a_result_modifier()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Result\ResultModifier');
    }

    public function it_sets_hydration_mode_to_object(AbstractQuery $query)
    {
        $query->setHydrationMode(Query::HYDRATE_SCALAR)->shouldBeCalled();

        $this->modify($query);
    }
}
