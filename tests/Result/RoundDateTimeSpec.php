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

namespace tests\Happyr\DoctrineSpecification\Result;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Parameter;
use Happyr\DoctrineSpecification\Result\RoundDateTime;
use PhpSpec\ObjectBehavior;

/**
 * @mixin RoundDateTime
 */
final class RoundDateTimeSpec extends ObjectBehavior
{
    private $roundSeconds = 3600;

    public function let(): void
    {
        $this->beConstructedWith($this->roundSeconds);
    }

    public function it_is_a_specification(): void
    {
        $this->shouldBeAnInstanceOf(RoundDateTime::class);
    }

    public function it_round_date_time_in_query_parameters_for_given_time(AbstractQuery $query): void
    {
        $name = 'now';
        $type = 'datetime';
        $actual = new \DateTime('15:55:34');
        $expected = new \DateTimeImmutable('15:00:00');

        $query->getParameters()->willReturn(new ArrayCollection([
            new Parameter('status', 'active'), // scalar param
            new Parameter($name, $actual, $type),
        ]));
        $query->setParameter($name, $expected, $type)->shouldBeCalled();

        $this->modify($query);
    }
}
