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
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\Having;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Having
 */
final class HavingSpec extends ObjectBehavior
{
    public function let(Filter $filter): void
    {
        $this->beConstructedWith($filter);
    }

    public function it_is_a_having(): void
    {
        $this->shouldBeAnInstanceOf(Having::class);
    }

    public function it_is_a_query_modifier(): void
    {
        $this->shouldHaveType(QueryModifier::class);
    }

    public function it_add_having(QueryBuilder $qb, Filter $filter): void
    {
        $this->beConstructedWith($filter);
        $filter->getFilter($qb, 'a')->willReturn('foo = :bar');
        $qb->having('foo = :bar')->shouldBeCalled();
        $this->modify($qb, 'a');
    }
}
