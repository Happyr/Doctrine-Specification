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

namespace tests\Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Filter\MemberOfX;
use Happyr\DoctrineSpecification\Logic\LogicX;
use Happyr\DoctrineSpecification\Operand\Addition;
use Happyr\DoctrineSpecification\Operand\Alias;
use Happyr\DoctrineSpecification\Operand\Division;
use Happyr\DoctrineSpecification\Operand\Multiplication;
use Happyr\DoctrineSpecification\Operand\PlatformFunction;
use Happyr\DoctrineSpecification\Operand\Subtraction;
use Happyr\DoctrineSpecification\Query\AddSelect;
use Happyr\DoctrineSpecification\Query\Distinct;
use Happyr\DoctrineSpecification\Query\Select;
use Happyr\DoctrineSpecification\Query\Selection\SelectAs;
use Happyr\DoctrineSpecification\Query\Selection\SelectEntity;
use Happyr\DoctrineSpecification\Query\Selection\SelectHiddenAs;
use Happyr\DoctrineSpecification\Spec;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Spec
 */
final class SpecSpec extends ObjectBehavior
{
    public function it_creates_an_x_specification(): void
    {
        $this->andX()->shouldReturnAnInstanceOf(LogicX::class);
    }

    public function it_creates_distinct(): void
    {
        $this->distinct()->shouldReturnAnInstanceOf(Distinct::class);
    }

    public function it_creates_add_operand(): void
    {
        $this->add('foo', 'bar')->shouldReturnAnInstanceOf(Addition::class);
    }

    public function it_creates_sub_operand(): void
    {
        $this->sub('foo', 'bar')->shouldReturnAnInstanceOf(Subtraction::class);
    }

    public function it_creates_mul_operand(): void
    {
        $this->mul('foo', 'bar')->shouldReturnAnInstanceOf(Multiplication::class);
    }

    public function it_creates_div_operand(): void
    {
        $this->div('foo', 'bar')->shouldReturnAnInstanceOf(Division::class);
    }

    public function it_creates_an_function(): void
    {
        $this->fun('UPPER', 'arg')->shouldReturnAnInstanceOf(PlatformFunction::class);
    }

    public function it_creates_an_function_with_many_args(): void
    {
        $this->fun('CONCAT', 'a', 'b')->shouldReturnAnInstanceOf(PlatformFunction::class);
    }

    public function it_creates_an_function_with_many_args_as_array(): void
    {
        $this->fun('CONCAT', ['a', 'b'])->shouldReturnAnInstanceOf(PlatformFunction::class);
    }

    public function it_creates_an_magic_function(): void
    {
        $this->__callStatic('UPPER', ['arg'])->shouldReturnAnInstanceOf(PlatformFunction::class);
    }

    public function it_creates_an_magic_function_many_args(): void
    {
        $this->__callStatic('CONCAT', ['a', 'b'])->shouldReturnAnInstanceOf(PlatformFunction::class);
    }

    public function it_creates_an_magic_function_many_args_inner(): void
    {
        $this->__callStatic('CONCAT', [['a', 'b']])->shouldReturnAnInstanceOf(PlatformFunction::class);
    }

    public function it_creates_select_query_modifier(): void
    {
        $this->select('foo')->shouldReturnAnInstanceOf(Select::class);
    }

    public function it_creates_add_select_query_modifier(): void
    {
        $this->addSelect('foo')->shouldReturnAnInstanceOf(AddSelect::class);
    }

    public function it_creates_select_entity_selection(): void
    {
        $this->selectEntity('u')->shouldReturnAnInstanceOf(SelectEntity::class);
    }

    public function it_creates_select_as_selection(): void
    {
        $this->selectAs('foo', 'bar')->shouldReturnAnInstanceOf(SelectAs::class);
    }

    public function it_creates_select_hidden_as_selection(): void
    {
        $this->selectHiddenAs('foo', 'bar')->shouldReturnAnInstanceOf(SelectHiddenAs::class);
    }

    public function it_creates_alias_operand(): void
    {
        $this->alias('foo')->shouldReturnAnInstanceOf(Alias::class);
    }

    public function it_creates_member_of_filter(): void
    {
        $this->memberOfX('foo', 'bar')->shouldReturnAnInstanceOf(MemberOfX::class);
    }
}
