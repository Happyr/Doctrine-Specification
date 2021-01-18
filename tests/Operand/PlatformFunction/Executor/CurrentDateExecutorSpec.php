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

use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\CurrentDateExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin CurrentDateExecutor
 */
final class CurrentDateExecutorSpec extends ObjectBehavior
{
    public function it_should_return_current_date(): void
    {
        $this()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this()->shouldBeWithDefaultTimeZone();
        $this()->shouldBeCurrentDate();
    }

    public function getMatchers(): array
    {
        return [
            'beWithDefaultTimeZone' => function (\DateTimeInterface $subject): bool {
                return $subject->getTimezone()->getName() === date_default_timezone_get();
            },
            'beCurrentDate' => function (\DateTimeInterface $subject): bool {
                return $subject->getTimestamp() === (new \DateTimeImmutable())->setTime(0, 0)->getTimestamp();
            },
        ];
    }
}
