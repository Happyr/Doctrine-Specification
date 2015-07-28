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
use Happyr\DoctrineSpecification\Query\GroupBy;
use Happyr\DoctrineSpecification\Query\InnerJoin;
use Happyr\DoctrineSpecification\Query\Join;
use Happyr\DoctrineSpecification\Query\LeftJoin;
use Happyr\DoctrineSpecification\Query\Limit;
use Happyr\DoctrineSpecification\Query\Offset;
use Happyr\DoctrineSpecification\Query\OrderBy;
use Happyr\DoctrineSpecification\Result\AsArray;
use Happyr\DoctrineSpecification\Result\AsSingle;
use Happyr\DoctrineSpecification\Result\AsSingleScalar;
use Happyr\DoctrineSpecification\Result\Cache;
use Happyr\DoctrineSpecification\Specification\CountOf;
use Happyr\DoctrineSpecification\Specification\Having;
use Happyr\DoctrineSpecification\Specification\Specification;

/**
 * Factory class for the specifications.
 */
class Spec
{
    /*
     * Logic
     */

    public static function andX()
    {
        return new AndX(func_get_args());
    }

    public static function orX()
    {
        return new OrX(func_get_args());
    }

    public static function not(Filter $spec)
    {
        return new Not($spec);
    }

    /*
     * Query modifier
     */

    public static function join($field, $newAlias, $dqlAlias = null)
    {
        return new Join($field, $newAlias, $dqlAlias);
    }

    public static function leftJoin($field, $newAlias, $dqlAlias = null)
    {
        return new LeftJoin($field, $newAlias, $dqlAlias);
    }

    public static function innerJoin($field, $newAlias, $dqlAlias = null)
    {
        return new InnerJoin($field, $newAlias, $dqlAlias);
    }

    public static function limit($count)
    {
        return new Limit($count);
    }

    public static function offset($count)
    {
        return new Offset($count);
    }

    public static function orderBy($field, $order = 'ASC', $dqlAlias = null)
    {
        return new OrderBy($field, $order, $dqlAlias);
    }

    public static function groupBy($field, $dqlAlias = null)
    {
        return new GroupBy($field, $dqlAlias);
    }

    /*
     * Result modifier
     */

    public static function asArray()
    {
        return new AsArray();
    }

    public static function asSingle()
    {
        return new AsSingle();
    }

    public static function asSingleScalar()
    {
        return new AsSingleScalar();
    }

    public static function cache($cacheLifetime)
    {
        return new Cache($cacheLifetime);
    }

    /*
     * Filters
     */

    public static function isNull($field, $dqlAlias = null)
    {
        return new IsNull($field, $dqlAlias);
    }

    public static function isNotNull($field, $dqlAlias = null)
    {
        return new IsNotNull($field, $dqlAlias);
    }

    public static function in($field, $value, $dqlAlias = null)
    {
        return new In($field, $value, $dqlAlias);
    }

    public static function notIn($field, $value, $dqlAlias = null)
    {
        return new Not(new In($field, $value, $dqlAlias));
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

    public static function instanceOfX($value, $dqlAlias = null)
    {
        return new InstanceOfX($value, $dqlAlias);
    }

    /*
     * Specifications
     */

    public static function countOf(Specification $spec)
    {
        return new CountOf($spec);
    }

    public static function having($spec)
    {
        return new Having($spec);
    }
}
