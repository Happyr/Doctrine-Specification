<?php

namespace tests\Happyr\DoctrineSpecification;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\EntitySpecificationRepository;
use Happyr\DoctrineSpecification\Result\ResultModifier;
use Happyr\DoctrineSpecification\Specification\Specification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin EntitySpecificationRepository
 */
class EntitySpecificationRepositorySpec extends ObjectBehavior
{
    private $alias = 'e';
    private $expression = 'expression';
    private $result = 'result';

    function let(EntityManager $entityManager, ClassMetadata $classMetadata)
    {
        $this->beConstructedWith($entityManager, $classMetadata);
    }

    function it_matches_a_specification_with_empty_filter(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    )
    {
        $this->prepareEntityManagerStub($entityManager, $qb);
        $this->prepareQueryBuilderStub($qb, $query);
        $query->execute()->willReturn($this->result);

        $qb->where()->shouldNotBeCalled();

        $this->match($specification)->shouldReturn($this->result);
    }

    function it_matches_a_specification_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    )
    {
        $this->prepareStubs($specification, $entityManager, $qb, $query);
        $query->execute()->willReturn($this->result);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $this->match($specification)->shouldReturn($this->result);
    }

    function it_matches_a_single_result_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    )
    {
        $singleResult = new \stdClass;

        $this->prepareStubs($specification, $entityManager, $qb, $query);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $query->getSingleResult()->willReturn($singleResult);

        $this->matchSingleResult($specification)->shouldReturn($singleResult);
    }

    function it_throws_exception_when_expecting_single_result_finding_none_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    )
    {
        $this->prepareStubs($specification, $entityManager, $qb, $query);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $query->getSingleResult()->willThrow(new NoResultException());

        $this->shouldThrow('Happyr\DoctrineSpecification\Exception\NoResultException')->duringMatchSingleResult($specification);
    }

    function it_throws_exception_when_expecting_single_result_finding_multiple_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    )
    {
        $this->prepareStubs($specification, $entityManager, $qb, $query);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $query->getSingleResult()->willThrow(new NonUniqueResultException());

        $this->shouldThrow('Happyr\DoctrineSpecification\Exception\NonUniqueResultException')->duringMatchSingleResult($specification);
    }

    function it_matches_a_single_result_when_expecting_one_or_null_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    )
    {
        $singleResult = new \stdClass;

        $this->prepareStubs($specification, $entityManager, $qb, $query);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $query->getSingleResult()->willReturn($singleResult);

        $this->matchOneOrNullResult($specification)->shouldReturn($singleResult);
    }

    function it_matches_null_when_expecting_one_or_null_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    )
    {
        $this->prepareStubs($specification, $entityManager, $qb, $query);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $query->getSingleResult()->willThrow(new NonUniqueResultException());

        $this->shouldThrow('Happyr\DoctrineSpecification\Exception\NonUniqueResultException')->duringMatchOneOrNullResult($specification);
    }

    function it_throws_exception_when_expecting_one_or_null_finding_multiple_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    )
    {
        $this->prepareStubs($specification, $entityManager, $qb, $query);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $query->getSingleResult()->willThrow(new NonUniqueResultException());

        $this->shouldThrow('Happyr\DoctrineSpecification\Exception\UnexpectedResultException')->duringMatchOneOrNullResult($specification);
    }


    function it_matches_a_specification_with_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query,
        ResultModifier $modifier
    )
    {
        $this->prepareStubs($specification, $entityManager, $qb, $query);
        $query->execute()->willReturn($this->result);

        $specification->modify($qb, $this->alias)->shouldBeCalled();
        $modifier->modify($query)->shouldBeCalled();

        $this->match($specification, $modifier)->shouldReturn($this->result);
    }

    private function prepareStubs(Specification $specification, EntityManager $entityManager, QueryBuilder $qb, AbstractQuery $query)
    {
        $this->prepareEntityManagerStub($entityManager, $qb);
        $this->prepareSpecificationStub($specification, $qb);
        $this->prepareQueryBuilderStub($qb, $query);
    }

    private function prepareEntityManagerStub(EntityManager $entityManager, QueryBuilder $qb)
    {
        $entityManager->createQueryBuilder()->willReturn($qb);
    }

    private function prepareSpecificationStub(Specification $specification, QueryBuilder $qb)
    {
        $specification->getFilter($qb, $this->alias)->willReturn($this->expression);
    }

    private function prepareQueryBuilderStub(QueryBuilder $qb, Query $query)
    {
        $qb->from(Argument::any(), $this->alias, null)->willReturn($qb);
        $qb->select($this->alias)->willReturn($qb);
        $qb->where($this->expression)->willReturn($qb);
        $qb->getQuery()->willReturn($query);
    }
}
