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

    /*
     * Filters
     */

    /**
     * @param string      $field
     * @param string|null $dqlAlias
     *
     * @return IsNull
     */
    public static function isNull($field, $dqlAlias = null)
    {
        return new IsNull($field, $dqlAlias);
    }

    /**
     * @param string      $field
     * @param string|null $dqlAlias
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
     * @param string $field
     * @param string $value
     * @param string $dqlAlias
     *
     * @return Comparison
     */
    public static function eq($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::EQ, $field, $value, $dqlAlias);
    }

    /**
     * @param string $field
     * @param string $value
     * @param string $dqlAlias
     *
     * @return Comparison
     */
    public static function neq($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::NEQ, $field, $value, $dqlAlias);
    }

    /**
     * @param string $field
     * @param string $value
     * @param string $dqlAlias
     *
     * @return Comparison
     */
    public static function lt($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::LT, $field, $value, $dqlAlias);
    }

    /**
     * @param string $field
     * @param string $value
     * @param string $dqlAlias
     *
     * @return Comparison
     */
    public static function lte($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::LTE, $field, $value, $dqlAlias);
    }

    /**
     * @param string $field
     * @param string $value
     * @param string $dqlAlias
     *
     * @return Comparison
     */
    public static function gt($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::GT, $field, $value, $dqlAlias);
    }

    /**
     * @param string $field
     * @param string $value
     * @param string $dqlAlias
     *
     * @return Comparison
     */
    public static function gte($field, $value, $dqlAlias = null)
    {
        return new Comparison(Comparison::GTE, $field, $value, $dqlAlias);
    }

    /**
     * @param string $field
     * @param string $value
     * @param string $format
     * @param string $dqlAlias
     *
     * @return Like
     */
    public static function like($field, $value, $format = Like::CONTAINS, $dqlAlias = null)
    {
        return new Like($field, $value, $format, $dqlAlias);
    }

    /**
     * @param string $value
     * @param null   $dqlAlias
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
     * @param Specification $spec
     *
     * @return CountOf
     */
    public static function countOf(Specification $spec)
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
}
