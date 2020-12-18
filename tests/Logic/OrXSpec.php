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

namespace tests\Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Equals;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Filter\GreaterThan;
use Happyr\DoctrineSpecification\Logic\OrX;
use Happyr\DoctrineSpecification\Specification\Specification;
use PhpSpec\ObjectBehavior;

/**
 * @mixin OrX
 */
final class OrXSpec extends ObjectBehavior
{
    public function let(Specification $specificationA, Specification $specificationB): void
    {
        $this->beConstructedWith($specificationA, $specificationB);
    }

    public function it_is_a_specification(): void
    {
        $this->shouldHaveType(Specification::class);
    }

    public function it_modifies_all_child_queries(
        QueryBuilder $queryBuilder,
        Specification $specificationA,
        Specification $specificationB
    ): void {
        $context = 'a';

        $specificationA->modify($queryBuilder, $context)->shouldBeCalled();
        $specificationB->modify($queryBuilder, $context)->shouldBeCalled();

        $this->modify($queryBuilder, $context);
    }

    public function it_composes_and_child_with_expression(
        QueryBuilder $qb,
        Expr $expression,
        Specification $specificationA,
        Specification $specificationB
    ): void {
        $filterA = 'foo';
        $filterB = 'bar';
        $context = 'a';

        $specificationA->getFilter($qb, $context)->willReturn($filterA);
        $specificationB->getFilter($qb, $context)->willReturn($filterB);
        $qb->expr()->willReturn($expression);

        $expression->orX($filterA, $filterB)->shouldBeCalled();

        $this->getFilter($qb, $context);
    }

    public function it_supports_expressions(
        QueryBuilder $qb,
        Expr $expression,
        Filter $exprA,
        Filter $exprB
    ): void {
        $this->beConstructedWith($exprA, $exprB);

        $filterA = 'foo';
        $filterB = 'bar';
        $context = 'a';

        $exprA->getFilter($qb, $context)->willReturn($filterA);
        $exprB->getFilter($qb, $context)->willReturn($filterB);
        $qb->expr()->willReturn($expression);

        $expression->orX($filterA, $filterB)->shouldBeCalled();

        $this->getFilter($qb, $context);
    }

    public function it_filter_collection(): void
    {
        $playersArr = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 9001],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 1230],
        ];

        $playersObj = [
            $this->createPlayer('Joe',   'M', 2500),
            $this->createPlayer('Moe',   'M', 9001),
            $this->createPlayer('Alice', 'F', 1230),
        ];

        $this->beConstructedWith(
            new Equals('gender', 'F'),
            new GreaterThan('points', 9000)
        );

        $this->filterCollection($playersArr)->shouldYield([$playersArr[1], $playersArr[2]]);
        $this->filterCollection($playersObj)->shouldYield([$playersObj[1], $playersObj[2]]);
    }

    public function it_filter_collection_not_satisfiable(Filter $exprA, Filter $exprB): void
    {
        $playersArr = [
            ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500],
            ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 1230],
            ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001],
        ];

        $playersObj = [
            $this->createPlayer('Joe',   'M', 2500),
            $this->createPlayer('Moe',   'M', 1230),
            $this->createPlayer('Alice', 'F', 9001),
        ];

        $this->beConstructedWith($exprA, $exprB);

        $this->filterCollection($playersArr)->shouldNotYield([]);
        $this->filterCollection($playersObj)->shouldNotYield([]);
    }

    public function it_is_satisfied_by(): void
    {
        $playerArrA = ['pseudo' => 'Joe',   'gender' => 'M', 'points' => 2500];
        $playerArrB = ['pseudo' => 'Moe',   'gender' => 'M', 'points' => 9001];
        $playerArrC = ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 1230];

        $playersObjA = $this->createPlayer('Joe',   'M', 2500);
        $playersObjB = $this->createPlayer('Moe',   'M', 9001);
        $playersObjC = $this->createPlayer('Alice', 'F', 1230);

        $this->beConstructedWith(
            new Equals('gender', 'F'),
            new GreaterThan('points', 9000)
        );

        $this->isSatisfiedBy($playerArrA)->shouldBe(false);
        $this->isSatisfiedBy($playerArrB)->shouldBe(true);
        $this->isSatisfiedBy($playerArrC)->shouldBe(true);
        $this->isSatisfiedBy($playersObjA)->shouldBe(false);
        $this->isSatisfiedBy($playersObjB)->shouldBe(true);
        $this->isSatisfiedBy($playersObjC)->shouldBe(true);
    }

    public function it_is_satisfied_by_not_satisfiable(Filter $exprA, Filter $exprB): void
    {
        $playerArr = ['pseudo' => 'Alice', 'gender' => 'F', 'points' => 9001];

        $playersObj = $this->createPlayer('Alice', 'F', 9001);

        $this->beConstructedWith($exprA, $exprB);

        $this->isSatisfiedBy($playerArr)->shouldBe(true);
        $this->isSatisfiedBy($playersObj)->shouldBe(true);
    }

    /**
     * @param string $pseudo
     * @param string $gender
     * @param int    $points
     *
     * @return \stdClass
     */
    private function createPlayer(string $pseudo, string $gender, int $points): \stdClass
    {
        $player = new \stdClass();
        $player->pseudo = $pseudo;
        $player->gender = $gender;
        $player->points = $points;

        return $player;
    }
}
