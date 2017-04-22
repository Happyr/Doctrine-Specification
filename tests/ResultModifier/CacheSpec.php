<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace tests\Happyr\DoctrineSpecification\ResultModifier;

use Doctrine\ORM\AbstractQuery;
use Happyr\DoctrineSpecification\ResultModifier\Cache;
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

    public function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\ResultModifier\Cache');
    }

    public function it_is_a_specification()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\ResultModifier\ResultModifier');
    }

    public function it_should_return_field()
    {
        $this->getCacheLifetime()->shouldReturn($this->lifetime);
    }
}
