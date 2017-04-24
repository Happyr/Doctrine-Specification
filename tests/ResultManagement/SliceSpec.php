<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace tests\Happyr\DoctrineSpecification\ResultManagement;

use Happyr\DoctrineSpecification\ResultManagement\Slice;
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
        $this->shouldHaveType('Happyr\DoctrineSpecification\ResultManagement\Slice');
    }

    public function it_is_a_specification()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Specification');
    }
}
