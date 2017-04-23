<?php

namespace tests\Happyr\DoctrineSpecification\Query;

use Happyr\DoctrineSpecification\Query\Slice;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Slice
 */
class SliceSpec extends ObjectBehavior
{
    /**
     * @var int
     */
    private $sliceSize = 25;

    public function let()
    {
        $this->beConstructedWith($this->sliceSize, 0);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Filter\Slice');
    }

    public function it_is_a_specification()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Query\QueryModifier');
    }
}
