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
    public function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\ResultModifier\AsSingleScalar');
    }

    public function it_is_a_result_modifier()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\ResultModifier\ResultModifier');
    }
}
