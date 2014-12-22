<?php

namespace spec\Happyr\DoctrineSpecification;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\EntitySpecificationRepository;
use Happyr\DoctrineSpecification\Result\ResultModifier;
use Happyr\DoctrineSpecification\Specification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin EntitySpecificationRepository
 */
class EntitySpecificationRepositorySpec extends ObjectBehavior
{
//    private $alias = 'e';
//    private $expression = 'expression';
//    private $result = 'result';
//
//    function let(EntityManager $entityManager, ClassMetadata $classMetadata)
//    {
//        $this->beConstructedWith($entityManager, $classMetadata);
//    }
//
//    function it_matches_a_specification_without_result_modifier(
//        Specification $specification,
//        EntityManager $entityManager,
//        QueryBuilder $qb,
//        AbstractQuery $query
//    )
//    {
//        $this->prepareStubs($specification, $entityManager, $qb, $query);
//
//        $specification->modify($qb, $this->alias)->shouldBeCalled();
//
//        $this->match($specification)->shouldReturn($this->result);
//    }
//
//    function it_matches_a_specification_with_result_modifier(
//        Specification $specification,
//        EntityManager $entityManager,
//        QueryBuilder $qb,
//        AbstractQuery $query,
//        ResultModifier $modifier
//    )
//    {
//        $this->prepareStubs($specification, $entityManager, $qb, $query);
//
//        $specification->modify($qb, $this->alias)->shouldBeCalled();
//        $modifier->modify($query)->shouldBeCalled();
//
//        $this->match($specification, $modifier)->shouldReturn($this->result);
//    }
//
//    private function prepareStubs(Specification $specification, EntityManager $entityManager, QueryBuilder $qb, AbstractQuery $query)
//    {
//        $entityManager->createQueryBuilder()->willReturn($qb);
//        $specification->getFilter($qb, $this->alias)->willReturn($this->expression);
//        $qb->from(Argument::any(), $this->alias)->willReturn($qb);
//        $qb->select($this->alias)->willReturn($qb);
//        $qb->where($this->expression)->willReturn($qb);
//        $qb->getQuery()->willReturn($query);
//        $query->execute()->willReturn($this->result);
//    }
}
