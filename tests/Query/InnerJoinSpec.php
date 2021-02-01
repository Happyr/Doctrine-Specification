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
use Happyr\DoctrineSpecification\Query\InnerJoin;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use PhpSpec\ObjectBehavior;

/**
 * @mixin InnerJoin
 */
final class InnerJoinSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('user', 'authUser', null);
    }

    public function it_is_a_query_modifier(): void
    {
        $this->shouldHaveType(QueryModifier::class);
    }

    public function it_joins_with_default_dql_alias(QueryBuilder $qb): void
    {
        $qb->innerJoin('a.user', 'authUser')->shouldBeCalled();

        $this->modify($qb, 'a');
    }

    public function it_joins_in_context(QueryBuilder $qb): void
    {
        $this->beConstructedWith('user', 'authUser', 'x');

        $qb->innerJoin('x.user', 'authUser')->shouldBeCalled();

        $qb->getDQLPart('join')->willReturn([]);
        $qb->getAllAliases()->willReturn([]);
        $qb->join('root.x', 'x')->willReturn($qb);

        $this->modify($qb, 'root');
    }
}
