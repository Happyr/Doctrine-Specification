<?php

namespace tests\Happyr\DoctrineSpecification\Specification;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Equals;
use Happyr\DoctrineSpecification\Query\GroupBy;
use Happyr\DoctrineSpecification\Specification\CountOf;
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

    public function it_is_a_specification()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Specification\Specification');
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
        $parameters_count = 0;
        $paramName = 'comparison_'.$parameters_count;

        $this->beConstructedWith(new Equals($field, $value, $dqlAlias));

        $qb->select(sprintf('COUNT(%s)', $dqlAlias))->shouldBeCalled();
        $qb->getParameters()->willReturn(new ArrayCollection());
        $qb->setParameter($paramName, $value)->shouldBeCalled();

        $this->getFilter($qb, $dqlAlias)->shouldBe(sprintf('%s.%s = :%s', $dqlAlias, $field, $paramName));
        $this->modify($qb, $dqlAlias);
    }
}
