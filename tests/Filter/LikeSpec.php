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

namespace tests\Happyr\DoctrineSpecification\Spec;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Like;
use Happyr\DoctrineSpecification\Specification\Specification;
use PhpSpec\ObjectBehavior;

class LikeSpec extends ObjectBehavior
{
    private $field = 'foo';

    private $value = 'bar';

    public function let(): void
    {
        $this->beConstructedWith($this->field, $this->value, Like::CONTAINS, 'dqlAlias');
    }

    public function it_is_a_specification(): void
    {
        $this->shouldHaveType(Specification::class);
    }

    public function it_surrounds_with_wildcards_when_using_contains(
        QueryBuilder $qb,
        ArrayCollection $parameters
    ): void {
        $this->beConstructedWith($this->field, $this->value, Like::CONTAINS, 'dqlAlias');
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(1);

        $qb->setParameter('comparison_1', '%bar%')->shouldBeCalled();

        $this->match($qb, null);
    }

    public function it_starts_with_wildcard_when_using_ends_with(QueryBuilder $qb, ArrayCollection $parameters): void
    {
        $this->beConstructedWith($this->field, $this->value, Like::ENDS_WITH, 'dqlAlias');
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(1);

        $qb->setParameter('comparison_1', '%bar')->shouldBeCalled();

        $this->match($qb, null);
    }

    public function it_ends_with_wildcard_when_using_starts_with(QueryBuilder $qb, ArrayCollection $parameters): void
    {
        $this->beConstructedWith($this->field, $this->value, Like::STARTS_WITH, 'dqlAlias');
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(1);

        $qb->setParameter('comparison_1', 'bar%')->shouldBeCalled();

        $this->match($qb, null);
    }
}
