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

namespace tests\Happyr\DoctrineSpecification\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\NonUniqueResultException as DoctrineNonUniqueResultException;
use Doctrine\ORM\NoResultException as DoctrineNoResultException;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\NonUniqueResultException;
use Happyr\DoctrineSpecification\Exception\NoResultException;
use Happyr\DoctrineSpecification\Exception\UnexpectedResultException;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Repository\EntitySpecificationRepository;
use Happyr\DoctrineSpecification\Result\ResultModifier;
use Happyr\DoctrineSpecification\Specification\Specification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin EntitySpecificationRepository
 */
final class EntitySpecificationRepositorySpec extends ObjectBehavior
{
    private $alias = 'root';

    private $expression = 'expression';

    private $result = 'result';

    public function let(EntityManager $entityManager, ClassMetadata $classMetadata): void
    {
        $this->beConstructedWith($entityManager, $classMetadata);
    }

    public function it_should_modify_query(
        QueryModifier $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    ): void {
        $this->prepareEntityManagerStub($entityManager, $qb);
        $this->prepareQueryBuilderStub($qb, $query);
        $query->execute()->willReturn($this->result);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $this->match($specification);
    }

    public function it_should_apply_filter(
        Filter $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    ): void {
        $this->prepareEntityManagerStub($entityManager, $qb);
        $this->prepareQueryBuilderStub($qb, $query);

        $specification->getFilter($qb, $this->alias)->willReturn($this->expression);

        $qb->andWhere($this->expression)->willReturn($qb);
        $qb->where()->shouldNotBeCalled();

        $this->match($specification);
    }

    public function it_should_skip_apply_empty_specification(
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    ): void {
        $this->prepareEntityManagerStub($entityManager, $qb);
        $this->prepareQueryBuilderStub($qb, $query);

        $qb->andWhere()->shouldNotBeCalled();
        $qb->where()->shouldNotBeCalled();

        $this->match(null);
    }

    public function it_matches_a_specification_with_empty_filter(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    ): void {
        $this->prepareEntityManagerStub($entityManager, $qb);
        $this->prepareQueryBuilderStub($qb, $query);
        $query->execute()->willReturn($this->result);

        $specification->modify($qb, $this->alias)->shouldBeCalled();
        $specification->getFilter($qb, $this->alias)->willReturn('');

        $qb->andWhere()->shouldNotBeCalled();
        $qb->where()->shouldNotBeCalled();

        $this->match($specification)->shouldReturn($this->result);
    }

    public function it_matches_a_specification_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    ): void {
        $this->prepareStubs($specification, $entityManager, $qb, $query);
        $query->execute()->willReturn($this->result);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $this->match($specification)->shouldReturn($this->result);
    }

    public function it_matches_a_single_result_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    ): void {
        $singleResult = new \stdClass();

        $this->prepareStubs($specification, $entityManager, $qb, $query);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $query->getSingleResult()->willReturn($singleResult);

        $this->matchSingleResult($specification)->shouldReturn($singleResult);
    }

    public function it_throws_exception_when_expecting_single_result_finding_none_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    ): void {
        $this->prepareStubs($specification, $entityManager, $qb, $query);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $query->getSingleResult()->willThrow(new DoctrineNoResultException());

        $this->shouldThrow(NoResultException::class)->duringMatchSingleResult($specification);
    }

    public function it_throws_exception_when_expecting_single_result_finding_multiple_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    ): void {
        $this->prepareStubs($specification, $entityManager, $qb, $query);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $query->getSingleResult()->willThrow(new DoctrineNonUniqueResultException());

        $this->shouldThrow(NonUniqueResultException::class)->duringMatchSingleResult($specification);
    }

    public function it_matches_a_single_scalar_result_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    ): void {
        $singleScalarResult = '1';

        $this->prepareStubs($specification, $entityManager, $qb, $query);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $query->getSingleScalarResult()->willReturn($singleScalarResult);

        $this->matchSingleScalarResult($specification)->shouldReturn($singleScalarResult);
    }

    public function it_throws_exception_when_expecting_single_scalar_result_finding_multiple_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    ): void {
        $this->prepareStubs($specification, $entityManager, $qb, $query);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $query->getSingleScalarResult()->willThrow(new DoctrineNonUniqueResultException());

        $this->shouldThrow(NonUniqueResultException::class)->duringMatchSingleScalarResult($specification);
    }

    public function it_matches_a_scalar_result_when_expecting_one_or_null_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    ): void {
        $scalarResult = ['1', '2', '3'];

        $this->prepareStubs($specification, $entityManager, $qb, $query);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $query->getScalarResult()->willReturn($scalarResult);

        $this->matchScalarResult($specification)->shouldReturn($scalarResult);
    }

    public function it_matches_a_single_result_when_expecting_one_or_null_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    ): void {
        $singleResult = new \stdClass();

        $this->prepareStubs($specification, $entityManager, $qb, $query);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $query->getSingleResult()->willReturn($singleResult);

        $this->matchOneOrNullResult($specification)->shouldReturn($singleResult);
    }

    public function it_matches_null_when_expecting_one_or_null_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    ): void {
        $this->prepareStubs($specification, $entityManager, $qb, $query);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $query->getSingleResult()->willThrow(new DoctrineNonUniqueResultException());

        $this->shouldThrow(NonUniqueResultException::class)->duringMatchOneOrNullResult($specification);
    }

    public function it_throws_exception_when_expecting_one_or_null_finding_multiple_without_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    ): void {
        $this->prepareStubs($specification, $entityManager, $qb, $query);

        $specification->modify($qb, $this->alias)->shouldBeCalled();

        $query->getSingleResult()->willThrow(new DoctrineNonUniqueResultException());

        $this->shouldThrow(UnexpectedResultException::class)->duringMatchOneOrNullResult($specification);
    }

    public function it_matches_a_specification_with_result_modifier(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query,
        ResultModifier $modifier
    ): void {
        $this->prepareStubs($specification, $entityManager, $qb, $query);
        $query->execute()->willReturn($this->result);

        $specification->modify($qb, $this->alias)->shouldBeCalled();
        $modifier->modify($query)->shouldBeCalled();

        $this->match($specification, $modifier)->shouldReturn($this->result);
    }

    private function prepareStubs(
        Specification $specification,
        EntityManager $entityManager,
        QueryBuilder $qb,
        AbstractQuery $query
    ): void {
        $this->prepareEntityManagerStub($entityManager, $qb);
        $this->prepareSpecificationStub($specification, $qb);
        $this->prepareQueryBuilderStub($qb, $query);
    }

    private function prepareEntityManagerStub(EntityManager $entityManager, QueryBuilder $qb): void
    {
        $entityManager->createQueryBuilder()->willReturn($qb);
    }

    private function prepareSpecificationStub(Specification $specification, QueryBuilder $qb): void
    {
        $specification->getFilter($qb, $this->alias)->willReturn($this->expression);
    }

    private function prepareQueryBuilderStub(QueryBuilder $qb, AbstractQuery $query): void
    {
        $qb->from(Argument::any(), $this->alias, null)->willReturn($qb);
        $qb->select($this->alias)->willReturn($qb);
        $qb->andWhere($this->expression)->willReturn($qb);
        $qb->getQuery()->willReturn($query);
    }
}
