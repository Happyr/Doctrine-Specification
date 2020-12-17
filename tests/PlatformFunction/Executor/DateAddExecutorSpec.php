<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification\PlatformFunction\Executor;

use Happyr\DoctrineSpecification\PlatformFunction\Executor\DateAddExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin DateAddExecutor
 */
final class DateAddExecutorSpec extends ObjectBehavior
{
    public function it_should_add_one_year(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this($now, 1, 'YEAR')->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this($now, 1, 'YEAR')->shouldBeSameTimeZone($now->getTimezone());
        $this($now, 1, 'YEAR')->shouldBeSameTimestamp($now->modify('+1 year'));
    }

    public function it_should_sub_one_year(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this($now, -1, 'YEAR')->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this($now, -1, 'YEAR')->shouldBeSameTimeZone($now->getTimezone());
        $this($now, -1, 'YEAR')->shouldBeSameTimestamp($now->modify('-1 year'));
    }

    public function it_should_add_one_month(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this($now, 1, 'MONTH')->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this($now, 1, 'MONTH')->shouldBeSameTimeZone($now->getTimezone());
        $this($now, 1, 'MONTH')->shouldBeSameTimestamp($now->modify('+1 month'));
    }

    public function it_should_sub_one_month(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this($now, -1, 'MONTH')->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this($now, -1, 'MONTH')->shouldBeSameTimeZone($now->getTimezone());
        $this($now, -1, 'MONTH')->shouldBeSameTimestamp($now->modify('-1 month'));
    }

    public function it_should_add_one_week(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this($now, 1, 'WEEK')->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this($now, 1, 'WEEK')->shouldBeSameTimeZone($now->getTimezone());
        $this($now, 1, 'WEEK')->shouldBeSameTimestamp($now->modify('+1 week'));
    }

    public function it_should_sub_one_week(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this($now, -1, 'WEEK')->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this($now, -1, 'WEEK')->shouldBeSameTimeZone($now->getTimezone());
        $this($now, -1, 'WEEK')->shouldBeSameTimestamp($now->modify('-1 week'));
    }

    public function it_should_add_one_day(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this($now, 1, 'DAY')->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this($now, 1, 'DAY')->shouldBeSameTimeZone($now->getTimezone());
        $this($now, 1, 'DAY')->shouldBeSameTimestamp($now->modify('+1 day'));
    }

    public function it_should_sub_one_day(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this($now, -1, 'DAY')->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this($now, -1, 'DAY')->shouldBeSameTimeZone($now->getTimezone());
        $this($now, -1, 'DAY')->shouldBeSameTimestamp($now->modify('-1 day'));
    }

    public function it_should_add_one_hour(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this($now, 1, 'HOUR')->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this($now, 1, 'HOUR')->shouldBeSameTimeZone($now->getTimezone());
        $this($now, 1, 'HOUR')->shouldBeSameTimestamp($now->modify('+1 hour'));
    }

    public function it_should_sub_one_hour(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this($now, -1, 'HOUR')->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this($now, -1, 'HOUR')->shouldBeSameTimeZone($now->getTimezone());
        $this($now, -1, 'HOUR')->shouldBeSameTimestamp($now->modify('-1 hour'));
    }

    public function it_should_add_one_minute(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this($now, 1, 'MINUTE')->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this($now, 1, 'MINUTE')->shouldBeSameTimeZone($now->getTimezone());
        $this($now, 1, 'MINUTE')->shouldBeSameTimestamp($now->modify('+1 minute'));
    }

    public function it_should_sub_one_minute(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this($now, -1, 'MINUTE')->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this($now, -1, 'MINUTE')->shouldBeSameTimeZone($now->getTimezone());
        $this($now, -1, 'MINUTE')->shouldBeSameTimestamp($now->modify('-1 minute'));
    }

    public function it_should_add_one_second(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this($now, 1, 'SECOND')->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this($now, 1, 'SECOND')->shouldBeSameTimeZone($now->getTimezone());
        $this($now, 1, 'SECOND')->shouldBeSameTimestamp($now->modify('+1 second'));
    }

    public function it_should_sub_one_second(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this($now, -1, 'SECOND')->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this($now, -1, 'SECOND')->shouldBeSameTimeZone($now->getTimezone());
        $this($now, -1, 'SECOND')->shouldBeSameTimestamp($now->modify('-1 second'));
    }

    public function getMatchers(): array
    {
        return [
            'beSameTimeZone' => function (\DateTimeInterface $subject, \DateTimeZone $expected): bool {
                return $subject->getTimezone()->getName() === $expected->getName();
            },
            'beSameTimestamp' => function (\DateTimeInterface $subject, \DateTimeInterface $expected): bool {
                return $subject->getTimestamp() === $expected->getTimestamp();
            },
        ];
    }
}
