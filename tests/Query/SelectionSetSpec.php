<?php

namespace tests\Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Query\SelectionSet;
use PhpSpec\ObjectBehavior;

/**
 * @mixin SelectionSet
 */
class SelectionSetSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('field');
    }

    public function it_is_a_result_modifier()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Query\QueryModifier');
    }

    public function it_accepts_string_for_fields(QueryBuilder $qb)
    {
        $this->beConstructedWith('field');
        $qb->select(['f.field'])->shouldBeCalled();
        $this->modify($qb, 'f');
    }

    public function it_accepts_array_for_fields(QueryBuilder $qb)
    {
        $this->beConstructedWith(['thing', 'another']);
        $qb->select(['f.thing', 'f.another'])->shouldBeCalled();
        $this->modify($qb, 'f');
    }

    public function it_replaces_selection_when_replace_flag_is_set(QueryBuilder $qb)
    {
        $qb->select(['f.bad_field', 'f.another_bad_field']);
        $this->beConstructedWith(['thing', 'another']);
        $qb->select(['f.thing', 'f.another'])->shouldBeCalled();
        $this->modify($qb, 'f');
    }

    public function it_uses_own_dql_alias(QueryBuilder $qb)
    {
        $this->beConstructedWith(['thing' => 'ret', 'd.another'], 'x');
        $qb->select(['x.thing AS ret', 'd.another'])->shouldBeCalled();
        $this->modify($qb, 'f');
    }

    public function it_can_recognize_aliased_embedded_object(QueryBuilder $qb)
    {
        $this->beConstructedWith(['thing', 'd.embedded.field' => 'ret']);
        $qb->select(['f.thing', 'd.embedded.field AS ret'])->shouldBeCalled();
        $this->modify($qb, 'f');
    }
}
