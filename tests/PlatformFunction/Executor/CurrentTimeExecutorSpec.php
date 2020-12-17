<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\PlatformFunction\Executor\CurrentTimeExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin CurrentTimeExecutor
 */
final class CurrentTimeExecutorSpec extends ObjectBehavior
{
    public function it_should_be_executable(): void
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
                return $subject->getTimestamp() === (new \DateTimeImmutable())->setDate(1, 1, 1)->getTimestamp();
            },
        ];
    }
}
