<?php

namespace tests\Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\Field;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Field
 */
class FieldSpec extends ObjectBehavior
{
    private $fieldName = 'foo';

    public function let()
    {
        $this->beConstructedWith($this->fieldName);
    }

    public function it_is_a_field()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Operand\Field');
    }

    public function it_is_a_operand()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Operand\Operand');
    }

    public function it_is_transformable(QueryBuilder $qb)
    {
        $dqlAlias = 'a';
        $expression = 'a.foo';

        $this->transform($qb, $dqlAlias)->shouldReturn($expression);
    }
}
