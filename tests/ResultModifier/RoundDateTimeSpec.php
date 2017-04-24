<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

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
