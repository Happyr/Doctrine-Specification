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

namespace tests\Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\OperandNotExecuteException;
use Happyr\DoctrineSpecification\Operand\Alias;
use Happyr\DoctrineSpecification\Operand\Operand;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Alias
 */
final class AliasSpec extends ObjectBehavior
{
    private $alias = 'foo';

    public function let(): void
    {
        $this->beConstructedWith($this->alias);
    }

    public function it_is_a_alias(): void
    {
        $this->shouldBeAnInstanceOf(Alias::class);
    }

    public function it_is_a_operand(): void
    {
        $this->shouldBeAnInstanceOf(Operand::class);
    }

    public function it_is_transformable(QueryBuilder $qb): void
    {
        $this->transform($qb, 'a')->shouldReturn($this->alias);
    }

    public function it_is_executable(): void
    {
        $candidate = null; // not used

        $this->shouldThrow(OperandNotExecuteException::class)->duringExecute($candidate);
    }
}
