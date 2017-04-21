<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace tests\Happyr\DoctrineSpecification\QueryModifier;

use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\QueryModifier\LeftJoin;
use PhpSpec\ObjectBehavior;

/**
 * @mixin LeftJoin
 */
class LeftJoinSpec extends ObjectBehavior
{
    private $field = 'user';

    private $alias = 'authUser';

    public function let()
    {
        $this->beConstructedWith($this->field, $this->alias, null);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\QueryModifier\LeftJoin');
    }

    public function it_is_a_specification()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\QueryModifier\QueryModifier');
    }

    public function it_should_return_field()
    {
        $this->getField()->shouldReturn($this->field);
    }

    public function it_should_return_alias()
    {
        $this->getAlias()->shouldReturn($this->alias);
    }

    public function it_should_return_empty_with()
    {
        $this->getWith()->shouldReturn(null);
    }

    public function it_should_return_with(Filter $with)
    {
        $this->beConstructedWith($this->field, $this->alias, $with);
        $this->getWith()->shouldReturn($with);
    }
}
