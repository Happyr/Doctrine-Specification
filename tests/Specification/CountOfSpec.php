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
final class CountOfSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(null);
    }

    public function it_is_a_CountOf(): void
    {
        $this->shouldBeAnInstanceOf(CountOf::class);
    }

    public function it_is_a_specification(): void
    {
        $this->shouldHaveType(Specification::class);
    }

    public function it_count_of_all(QueryBuilder $qb): void
    {
        $context = 'a';

        $qb->select(sprintf('COUNT(%s)', $context))->shouldBeCalled();

        $this->getFilter($qb, $context)->shouldBe('');
        $this->modify($qb, $context);
    }

    public function it_count_of_all_grouped_by_id(QueryBuilder $qb): void
    {
        $field = 'id';
        $context = 'user';

        $this->beConstructedWith(new GroupBy($field, $context));

        $qb->select('COUNT(root)')->shouldBeCalled();
        $qb->addGroupBy(sprintf('%s.%s', $context, $field))->shouldBeCalled();

        $qb->getDQLPart('join')->willReturn([]);
        $qb->getAllAliases()->willReturn([]);
        $qb->join('root.user', 'user')->willReturn($qb);

        $this->getFilter($qb, 'root')->shouldBe('');
        $this->modify($qb, 'root');
    }

    public function it_count_of_all_with_group_is_foo(QueryBuilder $qb): void
    {
        $field = 'group';
        $value = 'foo';
        $context = 'user';
        $parametersCount = 0;
        $paramName = 'comparison_'.$parametersCount;

        $this->beConstructedWith(new Equals($field, $value, $context));

        $qb->select('COUNT(root)')->shouldBeCalled();
        $qb->getParameters()->willReturn(new ArrayCollection());
        $qb->setParameter($paramName, $value, null)->shouldBeCalled();

        $qb->getDQLPart('join')->willReturn([]);
        $qb->getAllAliases()->willReturn([]);
        $qb->join('root.user', 'user')->willReturn($qb);

        $this->getFilter($qb, 'root')->shouldBe(sprintf('%s.%s = :%s', $context, $field, $paramName));
        $this->modify($qb, 'root');
    }
}
