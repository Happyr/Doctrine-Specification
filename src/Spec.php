<?php

namespace Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Filter\Comparison;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Filter\In;
use Happyr\DoctrineSpecification\Filter\InstanceOfX;
use Happyr\DoctrineSpecification\Filter\IsNotNull;
use Happyr\DoctrineSpecification\Filter\IsNull;
use Happyr\DoctrineSpecification\Filter\Like;
use Happyr\DoctrineSpecification\Logic\AndX;
use Happyr\DoctrineSpecification\Logic\Not;
use Happyr\DoctrineSpecification\Logic\OrX;
use Happyr\DoctrineSpecification\Operand\BitAnd;
use Happyr\DoctrineSpecification\Operand\BitLeftShift;
use Happyr\DoctrineSpecification\Operand\BitNot;
use Happyr\DoctrineSpecification\Operand\BitOr;
use Happyr\DoctrineSpecification\Operand\BitRightShift;
use Happyr\DoctrineSpecification\Operand\BitXor;
use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Operand\LikePattern;
use Happyr\DoctrineSpecification\Operand\Operand;
use Happyr\DoctrineSpecification\Operand\Value;
use Happyr\DoctrineSpecification\Operand\Values;
use Happyr\DoctrineSpecification\Query\GroupBy;
use Happyr\DoctrineSpecification\Query\InnerJoin;
use Happyr\DoctrineSpecification\Query\Join;
use Happyr\DoctrineSpecification\Query\LeftJoin;
use Happyr\DoctrineSpecification\Query\Limit;
use Happyr\DoctrineSpecification\Query\Offset;
use Happyr\DoctrineSpecification\Query\OrderBy;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Query\Slice;
use Happyr\DoctrineSpecification\Result\AsArray;
use Happyr\DoctrineSpecification\Result\AsSingleScalar;
use Happyr\DoctrineSpecification\Result\Cache;
use Happyr\DoctrineSpecification\Result\RoundDateTime;
use Happyr\DoctrineSpecification\Specification\CountOf;
use Happyr\DoctrineSpecification\Specification\Having;

/**
 * Factory class for the specifications.
 */
class Spec
{
    /*
     * Logic
     */

    /**
     * @return AndX
     */
    public static function andX()
    {
        $args = func_get_args();
        $reflection = new \ReflectionClass('Happyr\DoctrineSpecification\Logic\AndX');

        return $reflection->newInstanceArgs($args);
    }

    /**
     * @return OrX
     */
    public static function orX()
    {
        $args = func_get_args();
        $reflection = new \ReflectionClass('Happyr\DoctrineSpecification\Logic\OrX');

        return $reflection->newInstanceArgs($args);
    }

    /**
     * @param Filter $spec
     *
     * @return Not
     */
    public static function not(Filter $spec)
    {
        return new Not($spec);
    }

    /*
     * Query modifier
     */

    /**
     * @param string $field
     * @param string $newAlias
     * @param string $dqlAlias
     *
     * @return Join
     */
    public static function join($field, $newAlias, $dqlAlias = null)
    {
        return new Join($field, $newAlias, $dqlAlias);
    }

    /**
     * @param string $field
     * @param string $newAlias
     * @param string $dqlAlias
     *
     * @return LeftJoin
     */
    public static function leftJoin($field, $newAlias, $dqlAlias = null)
    {
        return new LeftJoin($field, $newAlias, $dqlAlias);
    }

    /**
     * @param string $field
     * @param string $newAlias
     * @param string $dqlAlias
     *
     * @return InnerJoin
     */
    public static function innerJoin($field, $newAlias, $dqlAlias = null)
    {
        return new InnerJoin($field, $newAlias, $dqlAlias);
    }

    /**
     * @param int $count
     *
     * @return Limit
     */
    public static function limit($count)
    {
        return new Limit($count);
    }

    /**
     * @param int $count
     *
     * @return Offset
     */
    public static function offset($count)
    {
        return new Offset($count);
    }

    /**
     * @param int $sliceSize
     * @param int $sliceNumber
     *
     * @return Slice
     */
    public static function slice($sliceSize, $sliceNumber = 0)
    {
        return new Slice($sliceSize, $sliceNumber);
    }

    /**
     * @param string      $field
     * @param string      $order
     * @param string|null $dqlAlias
     *
     * @return OrderBy
     */
    public static function orderBy($field, $order = 'ASC', $dqlAlias = null)
    {
        return new OrderBy($field, $order, $dqlAlias);
    }

    /**
     * @param string $field
     * @param string $dqlAlias
     *
     * @return GroupBy
     */
    public static function groupBy($field, $dqlAlias = null)
    {
        return new GroupBy($field, $dqlAlias);
    }

    /*
     * Result modifier
     */

    /**
     * @return AsArray
     */
    public static function asArray()
    {
        return new AsArray();
    }

    /**
     * @return AsSingleScalar
     */
    public static function asSingleScalar()
    {
        return new AsSingleScalar();
    }

    /**
     * @param int $cacheLifetime How many seconds the cached entry is valid
     *
     * @return Cache
     */
    public static function cache($cacheLifetime)
    {
        return new Cache($cacheLifetime);
    }

    /**
     * @param int $roundSeconds How may seconds to round time
     *
     * @return RoundDateTime
     */
    public static function roundDateTimeParams($roundSeconds)
    {
        return new RoundDateTime($roundSeconds);
    }

    /*
     * Filters
     */

    /**
     * @param Operand|string $field
     * @param string|null    $dqlAlias
     *
     * @return IsNull
     */
    public static function isNull($field, $dqlAlias = null)
    {
        return new IsNull($field, $dqlAlias);
    }

    /**
     * @param Operand|string $field
     * @param string|null    $dqlAlias
     *
     * @return IsNotNull
     */
    public static function isNotNull($field, $dqlAlias = null)
    {
        return new IsNotNull($field, $dqlAlias);
    }

    /**
     * Make sure the $field has a value equals to $value.
     *
     * @param string $field
     * @param mixed  $value
     * @param string $dqlAlias
     *
     * @return In
     */
    public static function in($field, $value, $dqlAlias = null)
    {
        return new In($field, $value, $dqlAlias);
    }

    /**
     * @param string $field
     * @param mixed  $value
     * @param string $dqlAlias
     *
     * @return Not
     */
    public static function notIn($field, $value, $dqlAlias = null)
    {
        return new Not(new In($field, $value, $dqlAlias));
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @return Comparison
     */
    public static function eq($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::EQ, $field, $value, $dqlAlias);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @return Comparison
     */
    public static function neq($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::NEQ, $field, $value, $dqlAlias);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @return Comparison
     */
    public static function lt($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::LT, $field, $value, $dqlAlias);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @return Comparison
     */
    public static function lte($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::LTE, $field, $value, $dqlAlias);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @return Comparison
     */
    public static function gt($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::GT, $field, $value, $dqlAlias);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @return Comparison
     */
    public static function gte($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::GTE, $field, $value, $dqlAlias);
    }

    /**
     * @param Operand|string $field
     * @param string         $value
     * @param string         $format
     * @param string|null    $dqlAlias
     *
     * @return Like
     */
    public static function like($field, $value, $format = Like::CONTAINS, $dqlAlias = null)
    {
        return new Like($field, $value, $format, $dqlAlias);
    }

    /**
     * @param string      $value
     * @param string|null $dqlAlias
     *
     * @return InstanceOfX
     */
    public static function instanceOfX($value, $dqlAlias = null)
    {
        return new InstanceOfX($value, $dqlAlias);
    }

    /*
     * Specifications
     */

    /**
     * @param Filter|QueryModifier $spec
     *
     * @return CountOf
     */
    public static function countOf($spec)
    {
        return new CountOf($spec);
    }

    /**
     * @param Filter|string $spec
     *
     * @return Having
     */
    public static function having($spec)
    {
        return new Having($spec);
    }

    /*
     * Operands
     */

    /**
     * @param string $fieldName
     *
     * @return Field
     */
    public static function field($fieldName)
    {
        return new Field($fieldName);
    }

    /**
     * @param mixed           $value
     * @param int|string|null $valueType
     *
     * @return Value
     */
    public static function value($value, $valueType = null)
    {
        return new Value($value, $valueType);
    }

    /**
     * @param array           $values
     * @param int|string|null $valueType
     *
     * @return Values
     */
    public static function values($values, $valueType = null)
    {
        return new Values($values, $valueType);
    }

    /**
     * @param string $value
     * @param string $format
     *
     * @return LikePattern
     */
    public static function likePattern($value, $format = LikePattern::CONTAINS)
    {
        return new LikePattern($value, $format);
    }

    /*
     * Bitwise operands
     */

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     *
     * @return BitAnd
     */
    public static function bAnd($field, $value)
    {
        return new BitAnd($field, $value);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     *
     * @return BitOr
     */
    public static function bOr($field, $value)
    {
        return new BitOr($field, $value);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     *
     * @return BitXor
     */
    public static function bXor($field, $value)
    {
        return new BitXor($field, $value);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     *
     * @return BitLeftShift
     */
    public static function bLs($field, $value)
    {
        return new BitLeftShift($field, $value);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     *
     * @return BitRightShift
     */
    public static function bRs($field, $value)
    {
        return new BitRightShift($field, $value);
    }

    /**
     * @param Operand|string $field
     *
     * @return BitNot
     */
    public static function bNot($field)
    {
        return new BitNot($field);
    }
}
