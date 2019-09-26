<?php

namespace tests\Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Filter\MemberOfX;
use Happyr\DoctrineSpecification\Logic\LogicX;
use Happyr\DoctrineSpecification\Operand\Addition;
use Happyr\DoctrineSpecification\Operand\Alias;
use Happyr\DoctrineSpecification\Operand\BitAnd;
use Happyr\DoctrineSpecification\Operand\BitOr;
use Happyr\DoctrineSpecification\Operand\CountDistinct;
use Happyr\DoctrineSpecification\Operand\Division;
use Happyr\DoctrineSpecification\Operand\Modulo;
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
class SpecSpec extends ObjectBehavior
{
    public function it_creates_an_x_specification()
    {
        $this->andX()->shouldReturnAnInstanceOf(LogicX::class);
    }

    public function it_creates_distinct()
    {
        $this->distinct()->shouldReturnAnInstanceOf(Distinct::class);
    }

    public function it_creates_count_distinct()
    {
        $this->countDistinct('foo')->shouldReturnAnInstanceOf(CountDistinct::class);
    }

    public function it_creates_add_operand()
    {
        $this->add('foo', 'bar')->shouldReturnAnInstanceOf(Addition::class);
    }

    public function it_creates_sub_operand()
    {
        $this->sub('foo', 'bar')->shouldReturnAnInstanceOf(Subtraction::class);
    }

    public function it_creates_mul_operand()
    {
        $this->mul('foo', 'bar')->shouldReturnAnInstanceOf(Multiplication::class);
    }

    public function it_creates_div_operand()
    {
        $this->div('foo', 'bar')->shouldReturnAnInstanceOf(Division::class);
    }

    public function it_creates_mod_operand()
    {
        $this->mod('foo', 'bar')->shouldReturnAnInstanceOf(Modulo::class);
    }

    public function it_create_bit_and_operand()
    {
        $this->bAnd('foo', 'bar')->shouldReturnAnInstanceOf(BitAnd::class);
    }

    public function it_create_bit_or_operand()
    {
        $this->bOr('foo', 'bar')->shouldReturnAnInstanceOf(BitOr::class);
    }

    public function it_creates_an_function()
    {
        $this->fun('UPPER', 'arg')->shouldReturnAnInstanceOf(PlatformFunction::class);
    }

    public function it_creates_an_function_with_many_args()
    {
        $this->fun('CONCAT', 'a', 'b')->shouldReturnAnInstanceOf(PlatformFunction::class);
    }

    public function it_creates_an_function_with_many_args_as_array()
    {
        $this->fun('CONCAT', ['a', 'b'])->shouldReturnAnInstanceOf(PlatformFunction::class);
    }

    public function it_creates_an_magic_function()
    {
        $this->__callStatic('UPPER', ['arg'])->shouldReturnAnInstanceOf(PlatformFunction::class);
    }

    public function it_creates_an_magic_function_many_args()
    {
        $this->__callStatic('CONCAT', ['a', 'b'])->shouldReturnAnInstanceOf(PlatformFunction::class);
    }

    public function it_creates_an_magic_function_many_args_inner()
    {
        $this->__callStatic('CONCAT', [['a', 'b']])->shouldReturnAnInstanceOf(PlatformFunction::class);
    }

    public function it_creates_select_query_modifier()
    {
        $this->select('foo')->shouldReturnAnInstanceOf(Select::class);
    }

    public function it_creates_add_select_query_modifier()
    {
        $this->addSelect('foo')->shouldReturnAnInstanceOf(AddSelect::class);
    }

    public function it_creates_select_entity_selection()
    {
        $this->selectEntity('u')->shouldReturnAnInstanceOf(SelectEntity::class);
    }

    public function it_creates_select_as_selection()
    {
        $this->selectAs('foo', 'bar')->shouldReturnAnInstanceOf(SelectAs::class);
    }

    public function it_creates_select_hidden_as_selection()
    {
        $this->selectHiddenAs('foo', 'bar')->shouldReturnAnInstanceOf(SelectHiddenAs::class);
    }

    public function it_creates_alias_operand()
    {
        $this->alias('foo')->shouldReturnAnInstanceOf(Alias::class);
    }

    public function it_creates_member_of_filter()
    {
        $this->memberOfX('foo', 'bar')->shouldReturnAnInstanceOf(MemberOfX::class);
    }
}
