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

namespace tests\Happyr\DoctrineSpecification\Specification;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Equals;
use Happyr\DoctrineSpecification\Query\GroupBy;
use Happyr\DoctrineSpecification\Specification\CountOf;
use Happyr\DoctrineSpecification\Specification\Specification;
use PhpSpec\ObjectBehavior;

/**
 * @mixin CountOf
 */
class CountOfSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(null);
    }

    public function it_is_a_CountOf()
    {
        $this->shouldBeAnInstanceOf(CountOf::class);
    }

    public function it_is_a_specification()
    {
        $this->shouldHaveType(Specification::class);
    }

    public function it_count_of_all(QueryBuilder $qb)
    {
        $dqlAlias = 'a';

        $qb->select(sprintf('COUNT(%s)', $dqlAlias))->shouldBeCalled();

        $this->getFilter($qb, $dqlAlias)->shouldBe('');
        $this->modify($qb, $dqlAlias);
    }

    public function it_count_of_all_grouped_by_id(QueryBuilder $qb)
    {
        $field = 'id';
        $dqlAlias = 'a';

        $this->beConstructedWith(new GroupBy($field, $dqlAlias));

        $qb->select(sprintf('COUNT(%s)', $dqlAlias))->shouldBeCalled();
        $qb->addGroupBy(sprintf('%s.%s', $dqlAlias, $field))->shouldBeCalled();

        $this->getFilter($qb, $dqlAlias)->shouldBe('');
        $this->modify($qb, $dqlAlias);
    }

    public function it_count_of_all_with_group_is_foo(QueryBuilder $qb)
    {
        $field = 'group';
        $value = 'foo';
        $dqlAlias = 'a';
        $parametersCount = 0;
        $paramName = 'comparison_'.$parametersCount;

        $this->beConstructedWith(new Equals($field, $value, $dqlAlias));

        $qb->select(sprintf('COUNT(%s)', $dqlAlias))->shouldBeCalled();
        $qb->getParameters()->willReturn(new ArrayCollection());
        $qb->setParameter($paramName, $value, null)->shouldBeCalled();

        $this->getFilter($qb, $dqlAlias)->shouldBe(sprintf('%s.%s = :%s', $dqlAlias, $field, $paramName));
        $this->modify($qb, $dqlAlias);
    }
}
