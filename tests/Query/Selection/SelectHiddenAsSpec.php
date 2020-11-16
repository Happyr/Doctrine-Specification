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

namespace tests\Happyr\DoctrineSpecification\Query\Selection;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Equals;
use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Operand\Value;
use Happyr\DoctrineSpecification\Query\Selection\SelectHiddenAs;
use Happyr\DoctrineSpecification\Query\Selection\Selection;
use PhpSpec\ObjectBehavior;

/**
 * @mixin SelectHiddenAs
 */
class SelectHiddenAsSpec extends ObjectBehavior
{
    private $field = 'foo';

    private $alias = 'bar';

    public function let()
    {
        $this->beConstructedWith($this->field, $this->alias);
    }

    public function it_is_a_select_as()
    {
        $this->shouldBeAnInstanceOf(SelectHiddenAs::class);
    }

    public function it_is_a_selection()
    {
        $this->shouldBeAnInstanceOf(Selection::class);
    }

    public function it_is_transformable(QueryBuilder $qb)
    {
        $dqlAlias = 'a';
        $expression = '(a.foo) AS HIDDEN bar';

        $this->transform($qb, $dqlAlias)->shouldReturn($expression);
    }

    public function it_is_transformable_field(QueryBuilder $qb)
    {
        $dqlAlias = 'a';
        $expression = '(a.foo) AS HIDDEN bar';
        $field = new Field('foo');

        $this->beConstructedWith($field, $this->alias);
        $this->transform($qb, $dqlAlias)->shouldReturn($expression);
    }

    public function it_is_transformable_value(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $dqlAlias = 'a';
        $expression = '(:comparison_10) AS HIDDEN bar';
        $value = new Value('foo');

        $this->beConstructedWith($value, $this->alias);

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 'foo', null)->shouldBeCalled();

        $this->transform($qb, $dqlAlias)->shouldReturn($expression);
    }

    public function it_is_transformable_filter(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $dqlAlias = 'a';
        $expression = '(a.foo = :comparison_10) AS HIDDEN bar';
        $filter = new Equals('foo', 'bar');

        $this->beConstructedWith($filter, $this->alias);

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', 'bar', null)->shouldBeCalled();

        $this->transform($qb, $dqlAlias)->shouldReturn($expression);
    }
}
