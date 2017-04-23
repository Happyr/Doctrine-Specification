<?php

namespace tests\Happyr\DoctrineSpecification\ResultModifier;

use Happyr\DoctrineSpecification\ResultModifier\RoundDateTime;

/**
 * @mixin RoundDateTime
 */
class RoundDateTimeSpec
{
    private $roundSeconds = 3600;

    public function let()
    {
        $this->beConstructedWith($this->roundSeconds);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\ResultModifier\RoundDateTime');
    }

    public function it_is_a_specification()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Result\RoundDateTime');
    }
}
