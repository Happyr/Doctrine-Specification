<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace tests\Happyr\DoctrineSpecification\QueryModifier;

use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\QueryModifier\InnerJoin;
use PhpSpec\ObjectBehavior;

/**
 * @mixin InnerJoin
 */
class InnerJoinSpec extends ObjectBehavior
{
    private $field = 'user';

    private $alias = 'authUser';

    public function let()
    {
        $this->beConstructedWith($this->field, $this->alias, null, null);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\QueryModifier\InnerJoin');
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

    public function it_should_return_empty_condition()
    {
        $this->getCondition()->shouldReturn(null);
    }

    public function it_should_return_empty_condition_type()
    {
        $this->getConditionType()->shouldReturn(null);
    }

    public function it_should_on_condition(Filter $condition)
    {
        $this->beConstructedWith($this->field, $this->alias, InnerJoin::ON, $condition);
        $this->getCondition()->shouldReturn($condition);
        $this->getConditionType()->shouldReturn(InnerJoin::ON);
    }

    public function it_should_with_condition(Filter $condition)
    {
        $this->beConstructedWith($this->field, $this->alias, InnerJoin::WITH, $condition);
        $this->getCondition()->shouldReturn($condition);
        $this->getConditionType()->shouldReturn(InnerJoin::WITH);
    }
}
