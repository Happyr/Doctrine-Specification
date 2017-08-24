<?php

namespace tests\Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Query\AddSelectionSet;
use PhpSpec\ObjectBehavior;

/**
 * @mixin AddSelectionSet
 */
class AddSelectionSetSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('field');
    }

    public function it_is_a_result_modifier()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Query\QueryModifier');
    }

    public function it_adds_selection(QueryBuilder $qb)
    {
        $qb->select(['f.first', 'f.second']);
        $this->beConstructedWith(['thing', 'another']);
        $qb->addSelect(['f.thing', 'f.another'])->shouldBeCalled();
        $this->modify($qb, 'f');
    }

    public function it_respects_foreign_dql_alias(QueryBuilder $qb)
    {
        $this->beConstructedWith(['thing', 'd.another']);
        $qb->addSelect(['f.thing', 'd.another'])->shouldBeCalled();
        $this->modify($qb, 'f');
    }

    public function it_supports_fields_aliasing(QueryBuilder $qb)
    {
        $this->beConstructedWith(['thing', 'd.another' => 'ret']);
        $qb->addSelect(['f.thing', 'd.another AS ret'])->shouldBeCalled();
        $this->modify($qb, 'f');
    }

    public function it_supports_fields_aliasing_for_own_fields(QueryBuilder $qb)
    {
        $this->beConstructedWith(['thing' => 'ret', 'd.another']);
        $qb->addSelect(['f.thing AS ret', 'd.another'])->shouldBeCalled();
        $this->modify($qb, 'f');
    }

    public function it_uses_own_dql_alias(QueryBuilder $qb)
    {
        $this->beConstructedWith(['thing' => 'ret', 'd.another'], 'x');
        $qb->addSelect(['x.thing AS ret', 'd.another'])->shouldBeCalled();
        $this->modify($qb, 'f');
    }

    public function it_can_recognize_aliased_embedded_object(QueryBuilder $qb)
    {
        $this->beConstructedWith(['thing', 'd.embedded.field' => 'ret']);
        $qb->addSelect(['f.thing', 'd.embedded.field AS ret'])->shouldBeCalled();
        $this->modify($qb, 'f');
    }
}
