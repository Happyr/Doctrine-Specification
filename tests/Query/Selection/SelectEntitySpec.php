<?php

namespace tests\Happyr\DoctrineSpecification\Query\Selection;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Query\Selection\SelectEntity;
use Happyr\DoctrineSpecification\Query\Selection\Selection;
use PhpSpec\ObjectBehavior;

/**
 * @mixin SelectEntity
 */
class SelectEntitySpec extends ObjectBehavior
{
    private $dqlAlias = 'u';

    public function let()
    {
        $this->beConstructedWith($this->dqlAlias);
    }

    public function it_is_a_select_entity()
    {
        $this->shouldBeAnInstanceOf(SelectEntity::class);
    }

    public function it_is_a_selection()
    {
        $this->shouldBeAnInstanceOf(Selection::class);
    }

    public function it_is_transformable(QueryBuilder $qb)
    {
        $this->transform($qb, 'a')->shouldReturn($this->dqlAlias);
    }
}
