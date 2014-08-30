<?php

namespace spec\Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Query\AsArray;
use Happyr\DoctrineSpecification\Specification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin AsArray
 */
class AsArraySpec extends ObjectBehavior
{
    function let(Specification $specification)
    {
        $this->beConstructedWith($specification);
    }

    function it_is_a_specification()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Specification');
    }

    function it_sets_hydration_mode_to_array(AbstractQuery $query)
    {
        $query->setHydrationMode(Query::HYDRATE_ARRAY)->shouldBeCalled();

        $this->modifyQuery($query);
    }

    function it_delegates_match_to_decorated_specification(Specification $specification, QueryBuilder $qb)
    {
        $dqlAlias = null;

        $specification->match($qb, $dqlAlias)->shouldBeCalled();

        $this->match($qb, $dqlAlias);
    }
}
