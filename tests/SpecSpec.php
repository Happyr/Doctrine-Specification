<?php

namespace tests\Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Spec;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Spec
 */
class SpecSpec extends ObjectBehavior
{
    public function it_creates_an_x_specification()
    {
        $this->andX()->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Logic\LogicX');
    }

    public function it_creates_select_query_modifier()
    {
        $this->select('foo')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Query\Select');
    }

    public function it_creates_add_select_query_modifier()
    {
        $this->addSelect('foo')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Query\AddSelect');
    }
}
