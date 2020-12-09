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

namespace tests\Happyr\DoctrineSpecification\Query\Selection;

use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Query\Selection\ArgumentToSelectionConverter;
use PhpSpec\ObjectBehavior;

/**
 * @mixin ArgumentToSelectionConverter
 */
final class ArgumentToSelectionConverterSpec extends ObjectBehavior
{
    public function it_is_a_converter(): void
    {
        $this->shouldBeAnInstanceOf(ArgumentToSelectionConverter::class);
    }

    public function it_not_convert_field_to_selection(): void
    {
        $field = new Field('foo');

        $this->toSelection($field)->shouldReturn($field);
    }

    public function it_convert_argument_to_field(): void
    {
        $this->toSelection('foo')->shouldBeAnInstanceOf(Field::class);
    }
}
