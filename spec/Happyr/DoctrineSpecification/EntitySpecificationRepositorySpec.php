<?php

namespace spec\Happyr\DoctrineSpecification;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\EntitySpecificationRepository;
use Happyr\DoctrineSpecification\Specification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin EntitySpecificationRepository
 */
class EntitySpecificationRepositorySpec extends ObjectBehavior
{
    function let(EntityManager $entityManager, ClassMetadata $classMetadata)
    {
        $this->beConstructedWith($entityManager, $classMetadata);
    }

    function it_throws_an_exception_if_entity_is_not_supported(Specification $specification)
    {
        $specification->supports(Argument::any())->willReturn(false);
        $this->shouldThrow(new \InvalidArgumentException("Specification not supported by this repository."))->duringMatch($specification);
    }

    function it_(Specification $specification, EntityManager $entityManager, QueryBuilder $qb, Expr $expr, AbstractQuery $query)
    {
        $specification->supports(Argument::any())->willReturn(true);
        $entityManager->createQueryBuilder()->willReturn($qb);
        $qb->select('e')->willReturn($qb);
        $qb->from(Argument::any(), 'e')->willReturn($qb);
        $specification->match($qb, 'e')->willReturn($expr);
        $qb->where($expr)->willReturn($qb);
        $qb->getQuery()->willReturn($query);

        $specification->modifyQuery($query)->shouldBeCalled();
        $result = array();
        $query->getResult()->willReturn($result);

        $this->match($specification)->shouldReturn($result);
    }
}
