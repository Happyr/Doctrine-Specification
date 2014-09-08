<?php

namespace Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\QueryOption\AsArray;
use Happyr\DoctrineSpecification\Where\Comparison\Comparison;
use Happyr\DoctrineSpecification\Where\Comparison\In;
use Happyr\DoctrineSpecification\Where\Comparison\IsNotNull;
use Happyr\DoctrineSpecification\Where\Comparison\IsNull;
use Happyr\DoctrineSpecification\Where\Comparison\Like;
use Happyr\DoctrineSpecification\Where\Logic\LogicX;
use Happyr\DoctrineSpecification\Where\Logic\Not;

/**
 * Factory class for the specifications
 *
 * @author Kacper Gunia
 * @author Tobias Nyholm
 */
class Spec
{
    public static function andX()
    {
        return new LogicX(LogicX::AND_X, func_get_args());
    }

    public static function orX()
    {
        return new LogicX(LogicX::OR_X, func_get_args());
    }

    public static function collection()
    {
        return new LogicX(LogicX::AND_X, func_get_args());
    }

    public static function asArray(Specification $spec)
    {
        return new AsArray($spec);
    }

    public static function not(Specification $spec)
    {
        return new Not($spec);
    }

    public static function isNull($field, $value, $dqlAlias = null)
    {
        return new IsNull($field, $value, $dqlAlias);
    }

    public static function isNotNull($field, $value, $dqlAlias = null)
    {
        return new IsNotNull($field, $value, $dqlAlias);
    }

    public static function in($field, $value, $dqlAlias = null)
    {
        return new In($field, $value, $dqlAlias);
    }

    public static function eq($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::EQ, $field, $value, $dqlAlias);
    }

    public static function neq($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::NEQ, $field, $value, $dqlAlias);
    }

    public static function lt($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::LT, $field, $value, $dqlAlias);
    }

    public static function lte($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::LTE, $field, $value, $dqlAlias);
    }

    public static function gt($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::GT, $field, $value, $dqlAlias);
    }

    public static function gte($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::GTE, $field, $value, $dqlAlias);
    }

    public static function like($field, $value, $format = Like::CONTAINS, $dqlAlias = null)
    {
        return new Like($field, $value, $format, $dqlAlias);
    }
}