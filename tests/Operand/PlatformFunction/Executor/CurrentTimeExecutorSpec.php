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

use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\CurrentTimeExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin CurrentTimeExecutor
 */
final class CurrentTimeExecutorSpec extends ObjectBehavior
{
    public function it_should_return_current_time(): void
    {
        $this()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this()->shouldBeWithDefaultTimeZone();
        $this()->shouldBeCurrentTime();
    }

    public function getMatchers(): array
    {
        return [
            'beWithDefaultTimeZone' => function (\DateTimeInterface $subject): bool {
                return $subject->getTimezone()->getName() === date_default_timezone_get();
            },
            'beCurrentTime' => function (\DateTimeInterface $subject): bool {
                return $subject->getTimestamp() === (new \DateTimeImmutable())->setDate(1, 1, 1)->getTimestamp();
            },
        ];
    }
}
