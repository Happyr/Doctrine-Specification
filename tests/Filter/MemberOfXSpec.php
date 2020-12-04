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
use Happyr\DoctrineSpecification\Filter\MemberOfX;
use PhpSpec\ObjectBehavior;

/**
 * @mixin MemberOfX
 */
class MemberOfXSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(18, 'age', 'a');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(MemberOfX::class);
    }

    public function it_is_an_expression()
    {
        $this->shouldBeAnInstanceOf(Filter::class);
    }

    public function it_returns_expression_func_object(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 18, null)->shouldBeCalled();

        $this->getFilter($qb, null)->shouldReturn(':comparison_10 MEMBER OF a.age');
    }
}
