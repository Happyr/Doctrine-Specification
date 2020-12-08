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

namespace tests\Happyr\DoctrineSpecification\Filter;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Filter\In;
use PhpSpec\ObjectBehavior;

/**
 * @mixin In
 */
class InSpec extends ObjectBehavior
{
    private $field = 'foobar';

    private $value = ['bar', 'baz'];

    public function let(): void
    {
        $this->beConstructedWith($this->field, $this->value, 'a');
    }

    public function it_is_an_expression(): void
    {
        $this->shouldBeAnInstanceOf(Filter::class);
    }

    public function it_returns_expression_func_object(QueryBuilder $qb, ArrayCollection $parameters, Expr $expr): void
    {
        $dqlAlias = 'a';
        $qb->expr()->willReturn($expr);
        $expr->in(sprintf('%s.%s', $dqlAlias, $this->field), ':comparison_10')->shouldBeCalled();

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', $this->value, null)->shouldBeCalled();

        $this->getFilter($qb, 'a');
    }
}
