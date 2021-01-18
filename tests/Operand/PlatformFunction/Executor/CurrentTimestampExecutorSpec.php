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

namespace tests\Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\CurrentTimestampExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin CurrentTimestampExecutor
 */
final class CurrentTimestampExecutorSpec extends ObjectBehavior
{
    public function it_should_return_current_timestamp(): void
    {
        $this()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this()->shouldBeWithDefaultTimeZone();
        $this()->shouldBeCurrentTimestamp();
    }

    public function getMatchers(): array
    {
        return [
            'beWithDefaultTimeZone' => function (\DateTimeInterface $subject): bool {
                return $subject->getTimezone()->getName() === date_default_timezone_get();
            },
            'beCurrentTimestamp' => function (\DateTimeInterface $subject): bool {
                return $subject->getTimestamp() === (new \DateTimeImmutable())->getTimestamp();
            },
        ];
    }
}
