<?php

namespace tests\Happyr\DoctrineSpecification\Specification;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr;
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

    public function it_count_of_all(QueryBuilder $qb, Expr $expr)
    {
        $dqlAlias = 'a';
        $expression = 'COUNT(a)';

        $qb->expr()->willReturn($expr);
        $expr->select($dqlAlias)->willReturn($expression);

        $qb->select($expr->select($dqlAlias))->shouldBeCalled();

        $this->getFilter($qb, $dqlAlias)->shouldBe('');
        $this->modify($qb, $dqlAlias);
    }

    public function it_count_of_all_grouped_by_id(QueryBuilder $qb, Expr $expr)
    {
        $field = 'id';
        $dqlAlias = 'a';
        $expression = 'COUNT(a)';

        $this->beConstructedWith(new GroupBy($field, $dqlAlias));

        $qb->expr()->willReturn($expr);
        $expr->select($dqlAlias)->willReturn($expression);

        $qb->select($expr->select($dqlAlias))->shouldBeCalled();
        $qb->addGroupBy(sprintf('%s.%s', $dqlAlias, $field))->shouldBeCalled();

        $this->getFilter($qb, $dqlAlias)->shouldBe('');
        $this->modify($qb, $dqlAlias);
    }

    public function it_count_of_all_with_group_is_foo(QueryBuilder $qb, Expr $expr)
    {
        $field = 'group';
        $value = 'foo';
        $dqlAlias = 'a';
        $parameters_count = 0;
        $paramName = 'comparison_'.$parameters_count;
        $expression = 'COUNT(a)';

        $this->beConstructedWith(new Equals($field, $value, $dqlAlias));

        $qb->expr()->willReturn($expr);
        $expr->select($dqlAlias)->willReturn($expression);

        $qb->select($expr->select($dqlAlias))->shouldBeCalled();
        $qb->getParameters()->willReturn(new ArrayCollection());
        $qb->setParameter($paramName, $value)->shouldBeCalled();

        $this->getFilter($qb, $dqlAlias)->shouldBe(sprintf('%s.%s = :%s', $dqlAlias, $field, $paramName));
        $this->modify($qb, $dqlAlias);
    }
}
