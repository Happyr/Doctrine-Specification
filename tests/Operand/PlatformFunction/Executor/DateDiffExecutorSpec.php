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

use Happyr\DoctrineSpecification\Operand\PlatformFunction\Executor\DateDiffExecutor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin DateDiffExecutor
 */
final class DateDiffExecutorSpec extends ObjectBehavior
{
    public function it_should_make_a_date_diff(): void
    {
        $date1 = new \DateTimeImmutable('2019-01-12 11:24:46');
        $date2 = new \DateTimeImmutable('2020-12-17 17:31:12');

        $this($date1, $date2)->shouldBeSameDateInterval($date1->diff($date2));
    }

    public function getMatchers(): array
    {
        return [
            'beSameDateInterval' => function (\DateInterval $subject, \DateInterval $expected): bool {
                return
                    $subject->y === $expected->y &&
                    $subject->m === $expected->m &&
                    $subject->d === $expected->d &&
                    $subject->h === $expected->h &&
                    $subject->i === $expected->i &&
                    $subject->s === $expected->s &&
                    $subject->invert === $expected->invert
                ;
            },
        ];
    }
}
