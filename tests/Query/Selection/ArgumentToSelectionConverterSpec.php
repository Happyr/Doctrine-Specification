<?php

namespace tests\Happyr\DoctrineSpecification\Query\Selection;

use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Query\Selection\ArgumentToSelectionConverter;
use PhpSpec\ObjectBehavior;

/**
 * @mixin ArgumentToSelectionConverter
 */
class ArgumentToSelectionConverterSpec extends ObjectBehavior
{
    public function it_is_a_converter()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Query\Selection\ArgumentToSelectionConverter');
    }

    public function it_not_convert_field_to_selection(Field $field)
    {
        $this->toSelection($field)->shouldReturn($field);
    }

    public function it_convert_argument_to_field()
    {
        $this->toSelection('foo')->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Operand\Field');
    }
}
