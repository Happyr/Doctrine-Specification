<?php

namespace tests\Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;
use Happyr\DoctrineSpecification\Result\Cache;
use Happyr\DoctrineSpecification\Result\ResultModifier;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Cache
 */
class CacheSpec extends ObjectBehavior
{
    private $lifetime = 3600;

    public function let()
    {
        $this->beConstructedWith($this->lifetime);
    }

    public function it_is_a_specification()
    {
        $this->shouldBeAnInstanceOf(ResultModifier::class);
    }

    public function it_caches_query_for_given_time(AbstractQuery $query)
    {
        $query->setResultCacheLifetime($this->lifetime)->shouldBeCalled();

        $this->modify($query);
    }
}
