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
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Query\Slice;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Slice
 */
final class SliceSpec extends ObjectBehavior
{
    /**
     * @var int
     */
    private $sliceSize = 25;

    public function let(): void
    {
        $this->beConstructedWith($this->sliceSize, 0);
    }

    public function it_is_a_query_modifier(): void
    {
        $this->shouldHaveType(QueryModifier::class);
    }

    public function it_slice_with_zero_index(QueryBuilder $qb): void
    {
        $this->beConstructedWith($this->sliceSize, 0);

        $qb->setMaxResults($this->sliceSize)->shouldBeCalled();

        $this->modify($qb, 'a');
    }

    public function it_slice_with_second_index(QueryBuilder $qb): void
    {
        $sliceNumber = 1;

        $this->beConstructedWith($this->sliceSize, $sliceNumber);

        $qb->setMaxResults($this->sliceSize)->shouldBeCalled();
        $qb->setFirstResult($this->sliceSize * $sliceNumber)->shouldBeCalled();

        $this->modify($qb, 'a');
    }
}
