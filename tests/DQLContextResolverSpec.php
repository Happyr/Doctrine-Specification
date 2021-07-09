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

namespace tests\Happyr\DoctrineSpecification;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\DQLContextResolver;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin DQLContextResolver
 */
final class DQLContextResolverSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this::enableDeadJoinsProtection();
        $this::enableConflictProtection();
        $this::enableAutoJoining();
        $this::useUniqueAliasIfNecessary();
    }

    public function it_resolve_not_joined_aliases(QueryBuilder $qb): void
    {
        $this::disableDeadJoinsProtection();

        $this::resolveAlias($qb, 'root')->shouldBe('root');
        $this::resolveAlias($qb, 'root.contestant')->shouldBe('contestant');
        $this::resolveAlias($qb, 'root.contestant.contest')->shouldBe('contest');
    }

    public function it_join_entity_without_conflict_protection(QueryBuilder $qb): void
    {
        $this::disableConflictProtection();

        $qb->getAllAliases()->willReturn(['contestant']);
        $qb->getDQLPart('join')->willReturn([
            'root' => [
                new Join(Join::INNER_JOIN, 'root.contestant', 'contestant'),
            ],
        ]);
        $qb->join('contestant.contest', 'contest')->willReturn($qb);

        $this::resolveAlias($qb, 'root.contestant.contest')->shouldBe('contest');
    }

    public function it_use_wrong_alias_from_another_entity(QueryBuilder $qb): void
    {
        $this::disableConflictProtection();

        $qb->getAllAliases()->willReturn(['contestant']);
        $qb->getDQLPart('join')->willReturn([
            'foo' => [
                new Join(Join::INNER_JOIN, 'foo.bar', 'contestant'),
            ],
        ]);

        $this::resolveAlias($qb, 'root.contestant')->shouldBe('contestant');
    }

    public function it_resolve_exists_alias(QueryBuilder $qb): void
    {
        $qb->getAllAliases()->willReturn(['contestant']);
        $qb->getDQLPart('join')->willReturn([
            'root' => [
                new Join(Join::INNER_JOIN, 'root.contestant', 'contestant'),
            ],
        ]);

        $this::resolveAlias($qb, 'root.contestant')->shouldBe('contestant');
    }

    public function it_resolve_wrong_alias_without_joining(QueryBuilder $qb): void
    {
        $this::disableConflictProtection();
        $this::disableAutoJoining();

        $qb->getAllAliases()->willReturn(['contestant']);
        $qb->getDQLPart('join')->willReturn([
            'foo' => [
                new Join(Join::INNER_JOIN, 'foo.bar', 'contestant'),
            ],
        ]);

        $this::resolveAlias($qb, 'root.contestant.contest')->shouldBe('contest');
    }

    public function it_join_entities(QueryBuilder $qb): void
    {
        $qb->getAllAliases()->willReturn([]);
        $qb->getDQLPart('join')->willReturn([]);
        $qb->join('root.contestant', 'contestant')->willReturn($qb);
        $qb->join('contestant.contest', 'contest')->willReturn($qb);

        $this::resolveAlias($qb, 'root.contestant.contest')->shouldBe('contest');
    }

    public function it_resolve_conflict(QueryBuilder $qb): void
    {
        $qb->getAllAliases()->willReturn(['contestant']);
        $qb->getDQLPart('join')->willReturn([
            'foo' => [
                new Join(Join::INNER_JOIN, 'foo.bar', 'contestant'),
            ],
        ]);
        $qb->join('root.contestant', Argument::that(function ($argument) {
            return preg_match('/^contestant[a-f0-9]+/', $argument);
        }))->willReturn($qb);
        $qb->join(Argument::that(function ($argument) {
            return preg_match('/^contestant[a-f0-9]+\.contest$/', $argument);
        }), 'contest')->willReturn($qb);

        $this::resolveAlias($qb, 'root.contestant.contest')->shouldBe('contest');
    }

    public function it_join_always_unique_alias(QueryBuilder $qb): void
    {
        $this::alwaysUseUniqueAlias();

        $qb->getAllAliases()->willReturn([]);
        $qb->getDQLPart('join')->willReturn([]);
        $qb->join('root.contestant', Argument::that(function ($argument) {
            return preg_match('/^contestant[a-f0-9]+/', $argument);
        }))->willReturn($qb);
        $qb->join(Argument::that(function ($argument) {
            return preg_match('/^contestant[a-f0-9]+\.contest$/', $argument);
        }), Argument::that(function ($argument) {
            return preg_match('/^contest[a-f0-9]+$/', $argument);
        }))->willReturn($qb);

        $this::resolveAlias($qb, 'root.contestant.contest')->shouldContain('contest');

        $this::useUniqueAliasIfNecessary();
    }
}
