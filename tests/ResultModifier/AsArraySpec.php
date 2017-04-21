<?php

namespace tests\Happyr\DoctrineSpecification\ResultModifier;

use Happyr\DoctrineSpecification\ResultModifier\AsArray;
use PhpSpec\ObjectBehavior;

/**
 * @mixin AsArray
 */
class AsArraySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\ResultModifier\AsArray');
    }

    public function it_is_a_result_modifier()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\ResultModifier\ResultModifier');
    }
}
