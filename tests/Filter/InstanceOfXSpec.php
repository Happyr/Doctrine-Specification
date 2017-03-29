<?php

namespace tests\Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\InstanceOfX;
use PhpSpec\ObjectBehavior;

/**
 * @mixin InstanceOfX
 */
class InstanceOfXSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('My\Model', 'o');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Filter\InstanceOfX');
    }

    public function it_is_an_expression()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Filter\Filter');
    }

    public function it_returns_expression_func_object(QueryBuilder $qb)
    {
        $this->getFilter($qb, null)->shouldReturn('o INSTANCE OF My\Model');
    }
}
