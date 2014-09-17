<?php

namespace Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Filter\IsNotNull;
use Happyr\DoctrineSpecification\Result\AsArray;
use Happyr\DoctrineSpecification\Filter\Comparison;
use Happyr\DoctrineSpecification\Filter\In;
use Happyr\DoctrineSpecification\Filter\Like;
use Happyr\DoctrineSpecification\Filter\IsNull;
use Happyr\DoctrineSpecification\Logic\LogicX;
use Happyr\DoctrineSpecification\Logic\Not;
use Happyr\DoctrineSpecification\Query\Join;

/**
 * Factory class for the specifications
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

    public static function join($field, $newAlias, $dqlAlias = null)
    {
        return new Join($field, $newAlias, $dqlAlias);
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
