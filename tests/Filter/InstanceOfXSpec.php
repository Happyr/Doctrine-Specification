<?php

namespace tests\Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
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
        $this->shouldHaveType(InstanceOfX::class);
    }

    public function it_is_an_expression()
    {
        $this->shouldBeAnInstanceOf(Filter::class);
    }

    public function it_returns_expression_func_object(QueryBuilder $qb)
    {
        $this->getFilter($qb, null)->shouldReturn('o INSTANCE OF My\Model');
    }
}
