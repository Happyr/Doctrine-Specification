<?php
declare(strict_types=1);

/**
 * This file is part of the Happyr Doctrine Specification package.
 *
 * (c) Tobias Nyholm <tobias@happyr.com>
 *     Kacper Gunia <kacper@gunia.me>
 *     Peter Gribanov <info@peter-gribanov.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;
use Happyr\DoctrineSpecification\Result\Cache;
use Happyr\DoctrineSpecification\Result\ResultModifier;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Cache
 */
final class CacheSpec extends ObjectBehavior
{
    private $lifetime = 3600;

    public function let(): void
    {
        $this->beConstructedWith($this->lifetime);
    }

    public function it_is_a_specification(): void
    {
        $this->shouldBeAnInstanceOf(ResultModifier::class);
    }

    public function it_caches_query_for_given_time(AbstractQuery $query): void
    {
        $query->setResultCacheLifetime($this->lifetime)->shouldBeCalled();

        $this->modify($query);
    }
}
