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

use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Operand\Operand;
use Happyr\DoctrineSpecification\Operand\Value;
use PhpSpec\ObjectBehavior;

/**
 * @mixin ArgumentToOperandConverter
 */
final class ArgumentToOperandConverterSpec extends ObjectBehavior
{
    public function it_is_a_converter(): void
    {
        $this->shouldBeAnInstanceOf(ArgumentToOperandConverter::class);
    }

    public function it_not_convert_operand_to_field(Operand $operand): void
    {
        $this->toField($operand)->shouldReturn($operand);
    }

    public function it_convert_argument_to_field(): void
    {
        $this->toField('foo')->shouldBeAnInstanceOf(Field::class);
    }

    public function it_not_convert_operand_to_value(Operand $operand): void
    {
        $this->toValue($operand)->shouldReturn($operand);
    }

    public function it_convert_argument_to_value(): void
    {
        $this->toValue('foo')->shouldBeAnInstanceOf(Value::class);
    }

    public function it_is_all_arguments_a_operands(Operand $first, Operand $second): void
    {
        $arguments = [$first, $second];
        $this->isAllOperands($arguments)->shouldReturn(true);
    }

    public function it_is_not_all_arguments_a_operands(Operand $first, Operand $second): void
    {
        $arguments = [$first, 'foo', $second];
        $this->isAllOperands($arguments)->shouldReturn(false);
    }

    public function it_no_nothing_to_convert(): void
    {
        $this->convert([])->shouldReturn([]);
    }

    public function it_a_convertible_field(): void
    {
        $subject = $this->convert(['foo']);
        $subject->shouldBeArray();
        $subject->shouldHaveCount(1);
        $subject->shouldHaveField();
    }

    public function it_a_already_converted_field(Operand $field): void
    {
        $this->convert([$field])->shouldReturn([$field]);
    }

    public function it_a_convertible_field_and_value(): void
    {
        $subject = $this->convert(['foo', 'bar']);
        $subject->shouldBeArray();
        $subject->shouldHaveCount(2);
        $subject->shouldHaveField();
        $subject->shouldHaveValue();
    }

    public function it_a_already_converted_value(Operand $field, Operand $value): void
    {
        $this->convert([$field, $value])->shouldReturn([$field, $value]);
    }

    public function it_a_already_converted_value2(Operand $value): void
    {
        $subject = $this->convert(['foo', $value]);
        $subject->shouldBeArray();
        $subject->shouldHaveCount(2);
        $subject->shouldHaveField();
        $subject->shouldHaveOperandAt(1);
    }

    public function it_a_convertible_arguments(Operand $first, Operand $second): void
    {
        $subject = $this->convert(['foo', $first, $second, 'bar']);
        $subject->shouldBeArray();
        $subject->shouldHaveCount(4);
        $subject->shouldHaveField();
        $subject->shouldHaveValue();
        $subject->shouldHaveOperandAt(1);
        $subject->shouldHaveOperandAt(2);
    }

    public function it_a_convertible_arguments2(Operand $operand): void
    {
        $subject = $this->convert([new Field('foo'), $operand, 'bar', new Value('baz')]);
        $subject->shouldBeArray();
        $subject->shouldHaveCount(4);
        $subject->shouldHaveField();
        $subject->shouldHaveValue();
        $subject->shouldHaveOperandAt(1);
        $subject->shouldHaveValueAt(2);
    }

    public function getMatchers(): array
    {
        return [
            'haveField' => function ($subject): bool {
                return $subject[0] instanceof Field;
            },
            'haveValue' => function ($subject): bool {
                return $subject[count($subject) - 1] instanceof Value;
            },
            'haveValueAt' => function ($subject, $position): bool {
                return $subject[$position] instanceof Value;
            },
            'haveOperandAt' => function ($subject, $position): bool {
                return $subject[$position] instanceof Operand;
            },
        ];
    }
}
