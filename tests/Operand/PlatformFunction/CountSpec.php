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

namespace tests\Happyr\DoctrineSpecification\Operand\PlatformFunction;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\OperandNotExecuteException;
use Happyr\DoctrineSpecification\Operand\Operand;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Count;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Count
 */
final class CountSpec extends ObjectBehavior
{
    private $field = 'foo';

    public function let(): void
    {
        $this->beConstructedWith($this->field);
    }

    public function it_is_a_count_distinct(): void
    {
        $this->shouldBeAnInstanceOf(Count::class);
    }

    public function it_is_a_operand(): void
    {
        $this->shouldBeAnInstanceOf(Operand::class);
    }

    public function it_is_transformable(QueryBuilder $qb): void
    {
        $this->transform($qb, 'a')->shouldReturn('COUNT(a.foo)');
    }

    public function it_is_transformable_distinct(QueryBuilder $qb): void
    {
        $this->beConstructedWith($this->field, true);

        $this->transform($qb, 'a')->shouldReturn('COUNT(DISTINCT a.foo)');
    }

    public function it_is_executable(): void
    {
        $candidate = null; // not used

        $this->shouldThrow(OperandNotExecuteException::class)->duringExecute($candidate);
    }
}
