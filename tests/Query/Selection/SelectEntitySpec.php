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

namespace tests\Happyr\DoctrineSpecification\Query\Selection;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Query\Selection\SelectEntity;
use Happyr\DoctrineSpecification\Query\Selection\Selection;
use PhpSpec\ObjectBehavior;

/**
 * @mixin SelectEntity
 */
final class SelectEntitySpec extends ObjectBehavior
{
    private $dqlAlias = 'u';

    public function let(): void
    {
        $this->beConstructedWith($this->dqlAlias);
    }

    public function it_is_a_select_entity(): void
    {
        $this->shouldBeAnInstanceOf(SelectEntity::class);
    }

    public function it_is_a_selection(): void
    {
        $this->shouldBeAnInstanceOf(Selection::class);
    }

    public function it_is_transformable(QueryBuilder $qb): void
    {
        $qb->getDQLPart('join')->willReturn([]);
        $qb->getAllAliases()->willReturn([]);
        $qb->join(sprintf('a.%s', $this->dqlAlias), $this->dqlAlias)->willReturn($qb);

        $this->transform($qb, 'a')->shouldReturn($this->dqlAlias);
    }

    public function it_is_transformable_in_context(QueryBuilder $qb): void
    {
        $context = 'foo.bar';

        $this->beConstructedWith(sprintf('%s.%s', $context, $this->dqlAlias));

        $qb->getDQLPart('join')->willReturn([]);
        $qb->getAllAliases()->willReturn([]);
        $qb->join('a.foo', 'foo')->willReturn($qb);
        $qb->join('foo.bar', 'bar')->willReturn($qb);
        $qb->join(sprintf('bar.%s', $this->dqlAlias), $this->dqlAlias)->willReturn($qb);

        $this->transform($qb, 'a')->shouldReturn($this->dqlAlias);
    }
}
