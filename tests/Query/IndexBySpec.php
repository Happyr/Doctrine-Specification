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
use Happyr\DoctrineSpecification\Query\IndexBy;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use PhpSpec\ObjectBehavior;

/**
 * @mixin IndexBy
 */
final class IndexBySpec extends ObjectBehavior
{
    private $field = 'the_field';

    private $alias = 'f';

    public function let(): void
    {
        $this->beConstructedWith($this->field, null);
    }

    public function it_is_a_query_modifier(): void
    {
        $this->shouldBeAnInstanceOf(QueryModifier::class);
    }

    public function it_indexes(QueryBuilder $qb): void
    {
        $qb->indexBy('a', sprintf('a.%s', $this->field))->shouldBeCalled();

        $this->modify($qb, 'a');
    }

    public function it_indexes_in_context(QueryBuilder $qb): void
    {
        $this->beConstructedWith('thing', 'user');

        $qb->indexBy('user', 'user.thing')->shouldBeCalled();

        $qb->getDQLPart('join')->willReturn([]);
        $qb->getAllAliases()->willReturn([]);
        $qb->join('root.user', 'user')->willReturn($qb);

        $this->modify($qb, 'root');
    }
}
