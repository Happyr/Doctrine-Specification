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

use Happyr\DoctrineSpecification\Operand\PlatformFunction\DateAdd;
use PhpSpec\ObjectBehavior;

/**
 * @mixin DateAdd
 */
final class DateAddSpec extends ObjectBehavior
{
    public function it_should_add_one_year(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this->beConstructedWith($now, 1, 'YEAR');

        $candidate = null; // not used

        $this->execute($candidate)->shouldReturnInstanceOf(\DateTimeImmutable::class);
        $this->execute($candidate)->shouldReturnSameTimeZone($now->getTimezone());
        $this->execute($candidate)->shouldReturnSameTimestamp($now->modify('+1 year'));
    }

    public function it_should_sub_one_year(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this->beConstructedWith($now, -1, 'YEAR');

        $candidate = null; // not used

        $this->execute($candidate)->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->execute($candidate)->shouldReturnSameTimeZone($now->getTimezone());
        $this->execute($candidate)->shouldReturnSameTimestamp($now->modify('-1 year'));
    }

    public function it_should_add_one_month(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this->beConstructedWith($now, 1, 'MONTH');

        $candidate = null; // not used

        $this->execute($candidate)->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->execute($candidate)->shouldReturnSameTimeZone($now->getTimezone());
        $this->execute($candidate)->shouldReturnSameTimestamp($now->modify('+1 month'));
    }

    public function it_should_sub_one_month(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this->beConstructedWith($now, -1, 'MONTH');

        $candidate = null; // not used

        $this->execute($candidate)->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->execute($candidate)->shouldReturnSameTimeZone($now->getTimezone());
        $this->execute($candidate)->shouldReturnSameTimestamp($now->modify('-1 month'));
    }

    public function it_should_add_one_week(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this->beConstructedWith($now, 1, 'WEEK');

        $candidate = null; // not used

        $this->execute($candidate)->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->execute($candidate)->shouldReturnSameTimeZone($now->getTimezone());
        $this->execute($candidate)->shouldReturnSameTimestamp($now->modify('+1 week'));
    }

    public function it_should_sub_one_week(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this->beConstructedWith($now, -1, 'WEEK');

        $candidate = null; // not used

        $this->execute($candidate)->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->execute($candidate)->shouldReturnSameTimeZone($now->getTimezone());
        $this->execute($candidate)->shouldReturnSameTimestamp($now->modify('-1 week'));
    }

    public function it_should_add_one_day(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this->beConstructedWith($now, 1, 'DAY');

        $candidate = null; // not used

        $this->execute($candidate)->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->execute($candidate)->shouldReturnSameTimeZone($now->getTimezone());
        $this->execute($candidate)->shouldReturnSameTimestamp($now->modify('+1 day'));
    }

    public function it_should_sub_one_day(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this->beConstructedWith($now, -1, 'DAY');

        $candidate = null; // not used

        $this->execute($candidate)->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->execute($candidate)->shouldReturnSameTimeZone($now->getTimezone());
        $this->execute($candidate)->shouldReturnSameTimestamp($now->modify('-1 day'));
    }

    public function it_should_add_one_hour(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this->beConstructedWith($now, 1, 'HOUR');

        $candidate = null; // not used

        $this->execute($candidate)->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->execute($candidate)->shouldReturnSameTimeZone($now->getTimezone());
        $this->execute($candidate)->shouldReturnSameTimestamp($now->modify('+1 hour'));
    }

    public function it_should_sub_one_hour(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this->beConstructedWith($now, -1, 'HOUR');

        $candidate = null; // not used

        $this->execute($candidate)->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->execute($candidate)->shouldReturnSameTimeZone($now->getTimezone());
        $this->execute($candidate)->shouldReturnSameTimestamp($now->modify('-1 hour'));
    }

    public function it_should_add_one_minute(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this->beConstructedWith($now, 1, 'MINUTE');

        $candidate = null; // not used

        $this->execute($candidate)->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->execute($candidate)->shouldReturnSameTimeZone($now->getTimezone());
        $this->execute($candidate)->shouldReturnSameTimestamp($now->modify('+1 minute'));
    }

    public function it_should_sub_one_minute(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this->beConstructedWith($now, -1, 'MINUTE');

        $candidate = null; // not used

        $this->execute($candidate)->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->execute($candidate)->shouldReturnSameTimeZone($now->getTimezone());
        $this->execute($candidate)->shouldReturnSameTimestamp($now->modify('-1 minute'));
    }

    public function it_should_add_one_second(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this->beConstructedWith($now, 1, 'SECOND');

        $candidate = null; // not used

        $this->execute($candidate)->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->execute($candidate)->shouldReturnSameTimeZone($now->getTimezone());
        $this->execute($candidate)->shouldReturnSameTimestamp($now->modify('+1 second'));
    }

    public function it_should_sub_one_second(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Tokyo'));

        $this->beConstructedWith($now, -1, 'SECOND');

        $candidate = null; // not used

        $this->execute($candidate)->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->execute($candidate)->shouldReturnSameTimeZone($now->getTimezone());
        $this->execute($candidate)->shouldReturnSameTimestamp($now->modify('-1 second'));
    }

    public function getMatchers(): array
    {
        return [
            'returnInstanceOf' => function (\DateTimeInterface $subject, string $expected): bool {
                return $subject instanceof $expected;
            },
            'returnSameTimeZone' => function (\DateTimeInterface $subject, \DateTimeZone $expected): bool {
                return $subject->getTimezone()->getName() === $expected->getName();
            },
            'returnSameTimestamp' => function (\DateTimeInterface $subject, \DateTimeInterface $expected): bool {
                return $subject->getTimestamp() === $expected->getTimestamp();
            },
        ];
    }
}
