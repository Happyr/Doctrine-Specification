<?php

namespace spec\Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Query\Cache;
use Happyr\DoctrineSpecification\Specification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin Cache
 */
class CacheSpec extends ObjectBehavior
{
    private $lifetime = 3600;

    function let(Specification $specification)
    {
        $this->beConstructedWith($specification, $this->lifetime);
    }

    function it_is_a_specification()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Specification');
    }

    function it_delegates_match_to_decorated_specification(Specification $specification, QueryBuilder $qb)
    {
        $dqlAlias = null;

        $specification->match($qb, $dqlAlias)->shouldBeCalled();

        $this->match($qb, $dqlAlias);
    }

    function it_supports_all_classes()
    {
        $this->supports(new \stdClass())->shouldReturn(true);
    }

    function it_caches_query_for_given_time(AbstractQuery $query)
    {
        $query->setResultCacheLifetime($this->lifetime)->shouldBeCalled();

        $this->modifyQuery($query);
    }
}
