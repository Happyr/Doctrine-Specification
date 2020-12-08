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

namespace tests\Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Query\Join;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Join
 */
class JoinSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('user', 'authUser', 'a');
    }

    public function it_is_a_specification(): void
    {
        $this->shouldHaveType(QueryModifier::class);
    }

    public function it_joins_with_default_dql_alias(QueryBuilder $qb): void
    {
        $qb->join('a.user', 'authUser')->shouldBeCalled();
        $this->modify($qb, 'a');
    }

    public function it_uses_local_alias_if_global_was_not_set(QueryBuilder $qb): void
    {
        $this->beConstructedWith('user', 'authUser');
        $qb->join('b.user', 'authUser')->shouldBeCalled();
        $this->modify($qb, 'b');
    }
}
