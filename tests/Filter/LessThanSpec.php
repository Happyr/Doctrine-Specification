<?php

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

namespace tests\Happyr\DoctrineSpecification\Filter;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Filter\LessThan;
use PhpSpec\ObjectBehavior;

/**
 * @mixin LessThan
 */
class LessThanSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('age', 18, 'a');
    }

    public function it_is_an_expression()
    {
        $this->shouldBeAnInstanceOf(Filter::class);
    }

    public function it_returns_comparison_object(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 18, null)->shouldBeCalled();

        $comparison = $this->getFilter($qb, null);

        $comparison->shouldReturn('a.age < :comparison_10');
    }

    public function it_uses_comparison_specific_dql_alias_if_passed(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $this->beConstructedWith('age', 18, null);

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 18, null)->shouldBeCalled();

        $this->getFilter($qb, 'x')->shouldReturn('x.age < :comparison_10');
    }
}
