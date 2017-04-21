<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace tests\Happyr\DoctrineSpecification\Filter;

use Happyr\DoctrineSpecification\Filter\IsNull;
use PhpSpec\ObjectBehavior;

/**
 * @mixin IsNull
 */
class IsNullSpec extends ObjectBehavior
{
    private $field = 'foobar';

    public function let()
    {
        $this->beConstructedWith($this->field);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Filter\IsNull');
    }

    public function it_is_an_expression()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Filter\Filter');
    }

    public function it_should_return_field()
    {
        $this->getField()->shouldReturn($this->field);
    }
}
