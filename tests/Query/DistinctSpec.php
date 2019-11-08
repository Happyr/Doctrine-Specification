<?php

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
use Happyr\DoctrineSpecification\Query\Distinct;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Distinct
 */
class DistinctSpec extends ObjectBehavior
{
    public function it_is_a_distinct()
    {
        $this->shouldBeAnInstanceOf(Distinct::class);
    }

    public function it_is_a_query_modifier()
    {
        $this->shouldHaveType(QueryModifier::class);
    }

    public function it_add_having(QueryBuilder $qb)
    {
        $qb->distinct()->shouldBeCalled();
        $this->modify($qb, 'a');
    }
}
