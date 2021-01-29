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

namespace tests\Happyr\DoctrineSpecification\Operand;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\LikePattern;
use Happyr\DoctrineSpecification\Operand\Operand;
use PhpSpec\ObjectBehavior;

/**
 * @mixin LikePattern
 */
final class LikePatternSpec extends ObjectBehavior
{
    private $value = 'foo';

    private $format = LikePattern::CONTAINS;

    public function let(): void
    {
        $this->beConstructedWith($this->value, $this->format);
    }

    public function it_is_a_like_pattern(): void
    {
        $this->shouldBeAnInstanceOf(LikePattern::class);
    }

    public function it_is_a_operand(): void
    {
        $this->shouldBeAnInstanceOf(Operand::class);
    }

    public function it_is_transformable(QueryBuilder $qb, ArrayCollection $parameters): void
    {
        $context = 'a';

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', sprintf($this->format, $this->value))->shouldBeCalled();

        $this->transform($qb, $context)->shouldReturn(':comparison_10');
    }

    public function it_is_executable(): void
    {
        $candidate = null; // not used

        $this->execute($candidate)->shouldReturn(sprintf($this->format, $this->value));
    }
}
