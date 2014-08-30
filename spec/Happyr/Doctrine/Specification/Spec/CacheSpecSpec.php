<?php

namespace spec\Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use Happyr\Doctrine\Specification\Spec\CacheSpec;
use Happyr\Doctrine\Specification\Spec\Specification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin CacheSpec
 */
class CacheSpecSpec extends ObjectBehavior
{
    private $lifetime = 3600;

    function let(Specification $specification)
    {
        $this->beConstructedWith($specification, $this->lifetime);
    }

    function it_is_a_specification()
    {
        $this->shouldBeAnInstanceOf('Happyr\Doctrine\Specification\Spec\Specification');
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
