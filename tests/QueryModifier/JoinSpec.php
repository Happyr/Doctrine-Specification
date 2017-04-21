<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace tests\Happyr\DoctrineSpecification\QueryModifier;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\QueryModifier\Join;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Join
 */
class JoinSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('user', 'authUser', 'a');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\QueryModifier\Join');
    }

    public function it_is_a_specification()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\QueryModifier\QueryModifier');
    }

    public function it_joins_with_default_dql_alias(QueryBuilder $qb)
    {
        $qb->join('a.user', 'authUser')->shouldBeCalled();
        $this->modify($qb, 'a');
    }

    public function it_uses_local_alias_if_global_was_not_set(QueryBuilder $qb)
    {
        $this->beConstructedWith('user', 'authUser');
        $qb->join('b.user', 'authUser')->shouldBeCalled();
        $this->modify($qb, 'b');
    }
}
