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

    public function it_creates_select_entity_selection()
    {
        $this->selectEntity('u')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Query\Selection\SelectEntity');
    }

    public function it_creates_select_as_selection()
    {
        $this->selectAs('foo', 'bar')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Query\Selection\SelectAs');
    }

    public function it_creates_select_hidden_as_selection()
    {
        $this->selectHiddenAs('foo', 'bar')->shouldReturnAnInstanceOf('Happyr\DoctrineSpecification\Query\Selection\SelectHiddenAs');
    }
}
