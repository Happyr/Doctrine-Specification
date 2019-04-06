<?php

namespace tests\Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Operand\PlatformFunction;
use PhpSpec\ObjectBehavior;

/**
 * @mixin PlatformFunction
 */
class PlatformFunctionSpec extends ObjectBehavior
{
    private $functionName = 'UPPER';

    private $arguments = 'foo';

    public function let()
    {
        $this->beConstructedWith($this->functionName, $this->arguments);
    }

    public function it_is_a_platform_function()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Operand\PlatformFunction');
    }

    public function it_is_a_operand()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Operand\Operand');
    }

    public function it_is_transformable_doctrine_function(QueryBuilder $qb)
    {
        $dqlAlias = 'a';
        $expression = 'UPPER(a.foo)';

        $this->transform($qb, $dqlAlias)->shouldReturn($expression);
    }

    public function it_is_transformable_many_arguments(QueryBuilder $qb)
    {
        $dqlAlias = 'a';
        $expression = 'concat(a.foo, a.bar)';

        $this->beConstructedWith('concat', new Field('foo'), new Field('bar'));

        $this->transform($qb, $dqlAlias)->shouldReturn($expression);
    }

    public function it_is_transformable_custom_string_function(
        QueryBuilder $qb,
        EntityManagerInterface $em,
        Configuration $configuration
    ) {
        $dqlAlias = 'a';
        $functionName = 'foo';
        $expression = 'foo(a.foo)';

        $qb->getEntityManager()->willReturn($em);
        $em->getConfiguration()->willReturn($configuration);
        $configuration->getCustomStringFunction($functionName)->willReturn('ToStringClass');
        $configuration->getCustomNumericFunction($functionName)->willReturn(null);
        $configuration->getCustomDatetimeFunction($functionName)->willReturn(null);

        $this->beConstructedWith($functionName, 'foo');

        $this->transform($qb, $dqlAlias)->shouldReturn($expression);
    }

    public function it_is_transformable_custom_numeric_function(
        QueryBuilder $qb,
        EntityManagerInterface $em,
        Configuration $configuration
    ) {
        $dqlAlias = 'a';
        $functionName = 'foo';
        $expression = 'foo(a.foo)';

        $qb->getEntityManager()->willReturn($em);
        $em->getConfiguration()->willReturn($configuration);
        $configuration->getCustomStringFunction($functionName)->willReturn(null);
        $configuration->getCustomNumericFunction($functionName)->willReturn('ToNumericClass');
        $configuration->getCustomDatetimeFunction($functionName)->willReturn(null);

        $this->beConstructedWith($functionName, 'foo');

        $this->transform($qb, $dqlAlias)->shouldReturn($expression);
    }

    public function it_is_transformable_custom_datetime_function(
        QueryBuilder $qb,
        EntityManagerInterface $em,
        Configuration $configuration
    ) {
        $dqlAlias = 'a';
        $functionName = 'foo';
        $expression = 'foo(a.foo)';

        $qb->getEntityManager()->willReturn($em);
        $em->getConfiguration()->willReturn($configuration);
        $configuration->getCustomStringFunction($functionName)->willReturn(null);
        $configuration->getCustomNumericFunction($functionName)->willReturn(null);
        $configuration->getCustomDatetimeFunction($functionName)->willReturn('ToDatetimeClass');

        $this->beConstructedWith($functionName, 'foo');

        $this->transform($qb, $dqlAlias)->shouldReturn($expression);
    }

    public function it_is_transformable_undefined_function(
        QueryBuilder $qb,
        EntityManagerInterface $em,
        Configuration $configuration
    ) {
        $functionName = 'foo';

        $qb->getEntityManager()->willReturn($em);
        $em->getConfiguration()->willReturn($configuration);
        $configuration->getCustomStringFunction($functionName)->willReturn(null);
        $configuration->getCustomNumericFunction($functionName)->willReturn(null);
        $configuration->getCustomDatetimeFunction($functionName)->willReturn(null);

        $this->beConstructedWith($functionName, 'foo');
        $this->shouldThrow('Happyr\DoctrineSpecification\Exception\InvalidArgumentException')
            ->during('transform', array($qb, 'a'));
    }

    public function it_is_transformable_not_convertible(QueryBuilder $qb)
    {
        $this->beConstructedWith('concat', ['foo', 'bar', 'baz']);

        $this->shouldThrow('Happyr\DoctrineSpecification\Exception\NotConvertibleException')
            ->during('transform', array($qb, 'a'));
    }
}
