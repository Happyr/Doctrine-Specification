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

namespace tests\Happyr\DoctrineSpecification\Operand;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Operand\Operand;
use Happyr\DoctrineSpecification\Operand\PlatformFunction;
use Happyr\DoctrineSpecification\Operand\Value;
use PhpSpec\ObjectBehavior;
use tests\Happyr\DoctrineSpecification\Player;

/**
 * @mixin PlatformFunction
 */
final class PlatformFunctionSpec extends ObjectBehavior
{
    private $functionName = 'UPPER';

    private $arguments = 'foo';

    public function let(): void
    {
        $this->beConstructedWith($this->functionName, $this->arguments);
    }

    public function it_is_a_platform_function(): void
    {
        $this->shouldBeAnInstanceOf(PlatformFunction::class);
    }

    public function it_is_a_operand(): void
    {
        $this->shouldBeAnInstanceOf(Operand::class);
    }

    public function it_is_transformable_doctrine_function(QueryBuilder $qb): void
    {
        $context = 'a';
        $expression = 'UPPER(a.foo)';

        $this->transform($qb, $context)->shouldReturn($expression);
    }

    public function it_is_transformable_many_arguments(QueryBuilder $qb): void
    {
        $context = 'a';
        $expression = 'concat(a.foo, a.bar)';

        $this->beConstructedWith('concat', new Field('foo'), new Field('bar'));

        $this->transform($qb, $context)->shouldReturn($expression);
    }

    public function it_is_transformable_custom_string_function(
        QueryBuilder $qb,
        EntityManagerInterface $em,
        Configuration $configuration
    ): void {
        $context = 'a';
        $functionName = 'foo';
        $expression = 'foo(a.foo)';

        $qb->getEntityManager()->willReturn($em);
        $em->getConfiguration()->willReturn($configuration);
        $configuration->getCustomStringFunction($functionName)->willReturn('ToStringClass');
        $configuration->getCustomNumericFunction($functionName)->willReturn(null);
        $configuration->getCustomDatetimeFunction($functionName)->willReturn(null);

        $this->beConstructedWith($functionName, 'foo');

        $this->transform($qb, $context)->shouldReturn($expression);
    }

    public function it_is_transformable_custom_numeric_function(
        QueryBuilder $qb,
        EntityManagerInterface $em,
        Configuration $configuration
    ): void {
        $context = 'a';
        $functionName = 'foo';
        $expression = 'foo(a.foo)';

        $qb->getEntityManager()->willReturn($em);
        $em->getConfiguration()->willReturn($configuration);
        $configuration->getCustomStringFunction($functionName)->willReturn(null);
        $configuration->getCustomNumericFunction($functionName)->willReturn('ToNumericClass');
        $configuration->getCustomDatetimeFunction($functionName)->willReturn(null);

        $this->beConstructedWith($functionName, 'foo');

        $this->transform($qb, $context)->shouldReturn($expression);
    }

    public function it_is_transformable_custom_datetime_function(
        QueryBuilder $qb,
        EntityManagerInterface $em,
        Configuration $configuration
    ): void {
        $context = 'a';
        $functionName = 'foo';
        $expression = 'foo(a.foo)';

        $qb->getEntityManager()->willReturn($em);
        $em->getConfiguration()->willReturn($configuration);
        $configuration->getCustomStringFunction($functionName)->willReturn(null);
        $configuration->getCustomNumericFunction($functionName)->willReturn(null);
        $configuration->getCustomDatetimeFunction($functionName)->willReturn('ToDatetimeClass');

        $this->beConstructedWith($functionName, 'foo');

        $this->transform($qb, $context)->shouldReturn($expression);
    }

    public function it_is_transformable_undefined_function(
        QueryBuilder $qb,
        EntityManagerInterface $em,
        Configuration $configuration
    ): void {
        $functionName = 'foo';

        $qb->getEntityManager()->willReturn($em);
        $em->getConfiguration()->willReturn($configuration);
        $configuration->getCustomStringFunction($functionName)->willReturn(null);
        $configuration->getCustomNumericFunction($functionName)->willReturn(null);
        $configuration->getCustomDatetimeFunction($functionName)->willReturn(null);

        $this->beConstructedWith($functionName, 'foo');
        $this->shouldThrow(InvalidArgumentException::class)->during('transform', [$qb, 'a']);
    }

    public function it_is_transformable_convertible(
        QueryBuilder $qb,
        EntityManagerInterface $em,
        Configuration $configuration,
        ArrayCollection $parameters
    ): void {
        $context = 'a';
        $functionName = 'concat';
        $expression = 'concat(a.foo, :comparison_10, :comparison_11)';

        $parameters->count()->willReturn(10, 11);

        $qb->getEntityManager()->willReturn($em);
        $qb->getParameters()->willReturn($parameters);
        $qb->setParameter('comparison_10', 'bar', null)->shouldBeCalled();
        $qb->setParameter('comparison_11', 'baz', null)->shouldBeCalled();

        $em->getConfiguration()->willReturn($configuration);

        $configuration->getCustomStringFunction($functionName)->willReturn('ToStringClass');
        $configuration->getCustomNumericFunction($functionName)->willReturn(null);
        $configuration->getCustomDatetimeFunction($functionName)->willReturn(null);

        $value = new Value('baz');

        $this->beConstructedWith($functionName, 'foo', 'bar', $value);

        $this->transform($qb, $context)->shouldReturn($expression);
    }

    public function it_is_executable_object(): void
    {
        $this->beConstructedWith('UPPER', 'pseudo');

        $player = new Player('Moe', 'M', 1230);

        $this->execute($player)->shouldReturn('MOE');
    }

    public function it_is_executable_array(): void
    {
        $this->beConstructedWith('UPPER', 'pseudo');

        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230];

        $this->execute($player)->shouldReturn('MOE');
    }

    public function it_is_executable_object_with_operands(): void
    {
        $this->beConstructedWith('UPPER', new Field('pseudo'));

        $player = new Player('Moe', 'M', 1230);

        $this->execute($player)->shouldReturn('MOE');
    }

    public function it_is_executable_array_with_operands(): void
    {
        $this->beConstructedWith('UPPER', new Field('pseudo'));

        $player = ['pseudo' => 'Moe', 'gender' => 'M', 'points' => 1230];

        $this->execute($player)->shouldReturn('MOE');
    }
}
