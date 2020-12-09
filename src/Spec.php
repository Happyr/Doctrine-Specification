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

namespace Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Filter\Equals;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Filter\GreaterOrEqualThan;
use Happyr\DoctrineSpecification\Filter\GreaterThan;
use Happyr\DoctrineSpecification\Filter\In;
use Happyr\DoctrineSpecification\Filter\InstanceOfX;
use Happyr\DoctrineSpecification\Filter\IsNotNull;
use Happyr\DoctrineSpecification\Filter\IsNull;
use Happyr\DoctrineSpecification\Filter\LessOrEqualThan;
use Happyr\DoctrineSpecification\Filter\LessThan;
use Happyr\DoctrineSpecification\Filter\Like;
use Happyr\DoctrineSpecification\Filter\MemberOfX;
use Happyr\DoctrineSpecification\Filter\NotEquals;
use Happyr\DoctrineSpecification\Logic\AndX;
use Happyr\DoctrineSpecification\Logic\Not;
use Happyr\DoctrineSpecification\Logic\OrX;
use Happyr\DoctrineSpecification\Operand\Addition;
use Happyr\DoctrineSpecification\Operand\Alias;
use Happyr\DoctrineSpecification\Operand\CountDistinct;
use Happyr\DoctrineSpecification\Operand\Division;
use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Operand\LikePattern;
use Happyr\DoctrineSpecification\Operand\Modulo;
use Happyr\DoctrineSpecification\Operand\Multiplication;
use Happyr\DoctrineSpecification\Operand\Operand;
use Happyr\DoctrineSpecification\Operand\PlatformFunction;
use Happyr\DoctrineSpecification\Operand\Subtraction;
use Happyr\DoctrineSpecification\Operand\Value;
use Happyr\DoctrineSpecification\Operand\Values;
use Happyr\DoctrineSpecification\Query\AddSelect;
use Happyr\DoctrineSpecification\Query\Distinct;
use Happyr\DoctrineSpecification\Query\GroupBy;
use Happyr\DoctrineSpecification\Query\Having;
use Happyr\DoctrineSpecification\Query\IndexBy;
use Happyr\DoctrineSpecification\Query\InnerJoin;
use Happyr\DoctrineSpecification\Query\Join;
use Happyr\DoctrineSpecification\Query\LeftJoin;
use Happyr\DoctrineSpecification\Query\Limit;
use Happyr\DoctrineSpecification\Query\Offset;
use Happyr\DoctrineSpecification\Query\OrderBy;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Query\Select;
use Happyr\DoctrineSpecification\Query\Selection\SelectAs;
use Happyr\DoctrineSpecification\Query\Selection\SelectEntity;
use Happyr\DoctrineSpecification\Query\Selection\SelectHiddenAs;
use Happyr\DoctrineSpecification\Query\Selection\Selection;
use Happyr\DoctrineSpecification\Query\Slice;
use Happyr\DoctrineSpecification\Result\AsArray;
use Happyr\DoctrineSpecification\Result\AsScalar;
use Happyr\DoctrineSpecification\Result\AsSingleScalar;
use Happyr\DoctrineSpecification\Result\Cache;
use Happyr\DoctrineSpecification\Result\RoundDateTime;
use Happyr\DoctrineSpecification\Specification\CountOf;

/**
 * Factory class for the specifications.
 *
 * @method static PlatformFunction CONCAT($str1, $str2)
 * @method static PlatformFunction SUBSTRING($str, $start, $length = null) Return substring of given string.
 * @method static PlatformFunction TRIM($str) Trim the string by the given trim char, defaults to whitespaces.
 * @method static PlatformFunction LOWER($str) Returns the string lowercased.
 * @method static PlatformFunction UPPER($str) Return the upper-case of the given string.
 * @method static PlatformFunction IDENTITY($expression, $fieldMapping = null) Retrieve the foreign key column of association of the owning side
 * @method static PlatformFunction LENGTH($str) Returns the length of the given string
 * @method static PlatformFunction LOCATE($needle, $haystack, $offset = 0) Locate the first occurrence of the substring in the string.
 * @method static PlatformFunction ABS($expression)
 * @method static PlatformFunction SQRT($q) Return the square-root of q.
 * @method static PlatformFunction SIZE($collection) Return the number of elements in the specified collection
 * @method static PlatformFunction DATE_DIFF($date1, $date2) Calculate the difference in days between date1-date2.
 * @method static PlatformFunction BIT_AND($a, $b)
 * @method static PlatformFunction BIT_OR($a, $b)
 * @method static PlatformFunction MIN($a)
 * @method static PlatformFunction MAX($a)
 * @method static PlatformFunction AVG($a)
 * @method static PlatformFunction SUM($a)
 * @method static PlatformFunction COUNT($a)
 * @method static PlatformFunction CURRENT_DATE() Return the current date
 * @method static PlatformFunction CURRENT_TIME() Returns the current time
 * @method static PlatformFunction CURRENT_TIMESTAMP() Returns a timestamp of the current date and time.
 * @method static PlatformFunction DATE_ADD($date, $days, $unit) Add the number of days to a given date. (Supported units are DAY, MONTH)
 * @method static PlatformFunction DATE_SUB($date, $days, $unit) Substract the number of days from a given date. (Supported units are DAY, MONTH)
 */
class Spec
{
    /**
     * @param string  $functionName
     * @param mixed[] $arguments
     *
     * @return PlatformFunction
     */
    public static function __callStatic(string $functionName, array $arguments = []): PlatformFunction
    {
        return self::fun($functionName, ...$arguments);
    }

    // Logic

    /**
     * @param Filter|QueryModifier ...$specs
     *
     * @return AndX
     */
    public static function andX(...$specs): AndX
    {
        return new AndX(...$specs);
    }

    /**
     * @param Filter|QueryModifier ...$specs
     *
     * @return OrX
     */
    public static function orX(...$specs): OrX
    {
        return new OrX(...$specs);
    }

    /**
     * @param Filter $spec
     *
     * @return Not
     */
    public static function not(Filter $spec): Not
    {
        return new Not($spec);
    }

    // Query modifier

    /**
     * @param string      $field
     * @param string      $newAlias
     * @param string|null $dqlAlias
     *
     * @return Join
     */
    public static function join(string $field, string $newAlias, ?string $dqlAlias = null): Join
    {
        return new Join($field, $newAlias, $dqlAlias);
    }

    /**
     * @param string      $field
     * @param string      $newAlias
     * @param string|null $dqlAlias
     *
     * @return LeftJoin
     */
    public static function leftJoin(string $field, string $newAlias, ?string $dqlAlias = null): LeftJoin
    {
        return new LeftJoin($field, $newAlias, $dqlAlias);
    }

    /**
     * @param string      $field
     * @param string      $newAlias
     * @param string|null $dqlAlias
     *
     * @return InnerJoin
     */
    public static function innerJoin(string $field, string $newAlias, ?string $dqlAlias = null): InnerJoin
    {
        return new InnerJoin($field, $newAlias, $dqlAlias);
    }

    /**
     * @param Field|string $field
     * @param string|null  $dqlAlias
     *
     * @return IndexBy
     */
    public static function indexBy($field, ?string $dqlAlias = null): IndexBy
    {
        return new IndexBy($field, $dqlAlias);
    }

    /**
     * @param int $count
     *
     * @return Limit
     */
    public static function limit(int $count): Limit
    {
        return new Limit($count);
    }

    /**
     * @param int $count
     *
     * @return Offset
     */
    public static function offset(int $count): Offset
    {
        return new Offset($count);
    }

    /**
     * @param int $sliceSize
     * @param int $sliceNumber
     *
     * @return Slice
     */
    public static function slice(int $sliceSize, int $sliceNumber = 0): Slice
    {
        return new Slice($sliceSize, $sliceNumber);
    }

    /**
     * @param Field|Alias|string $field
     * @param string             $order
     * @param string|null        $dqlAlias
     *
     * @return OrderBy
     */
    public static function orderBy($field, string $order = 'ASC', ?string $dqlAlias = null): OrderBy
    {
        return new OrderBy($field, $order, $dqlAlias);
    }

    /**
     * @param Field|Alias|string $field
     * @param string|null        $dqlAlias
     *
     * @return GroupBy
     */
    public static function groupBy($field, ?string $dqlAlias = null): GroupBy
    {
        return new GroupBy($field, $dqlAlias);
    }

    /**
     * @return Distinct
     */
    public static function distinct(): Distinct
    {
        return new Distinct();
    }

    // Selection

    /**
     * @param Selection|string ...$fields
     *
     * @return Select
     */
    public static function select(...$fields): Select
    {
        return new Select(...$fields);
    }

    /**
     * @param Selection|string ...$fields
     *
     * @return AddSelect
     */
    public static function addSelect(...$fields): AddSelect
    {
        return new AddSelect(...$fields);
    }

    /**
     * @param string $dqlAlias
     *
     * @return SelectEntity
     */
    public static function selectEntity(string $dqlAlias): SelectEntity
    {
        return new SelectEntity($dqlAlias);
    }

    /**
     * @param Filter|Operand|string $expression
     * @param string                $alias
     *
     * @return SelectAs
     */
    public static function selectAs($expression, string $alias): SelectAs
    {
        return new SelectAs($expression, $alias);
    }

    /**
     * @param Filter|Operand|string $expression
     * @param string                $alias
     *
     * @return SelectHiddenAs
     */
    public static function selectHiddenAs($expression, string $alias): SelectHiddenAs
    {
        return new SelectHiddenAs($expression, $alias);
    }

    // Result modifier

    /**
     * @return AsArray
     */
    public static function asArray(): AsArray
    {
        return new AsArray();
    }

    /**
     * @return AsSingleScalar
     */
    public static function asSingleScalar(): AsSingleScalar
    {
        return new AsSingleScalar();
    }

    /**
     * @return AsScalar
     */
    public static function asScalar(): AsScalar
    {
        return new AsScalar();
    }

    /**
     * @param int $cacheLifetime How many seconds the cached entry is valid
     *
     * @return Cache
     */
    public static function cache(int $cacheLifetime): Cache
    {
        return new Cache($cacheLifetime);
    }

    /**
     * @param int $roundSeconds How may seconds to round time
     *
     * @return RoundDateTime
     */
    public static function roundDateTimeParams(int $roundSeconds): RoundDateTime
    {
        return new RoundDateTime($roundSeconds);
    }

    // Filters

    /**
     * @param Operand|string $field
     * @param string|null    $dqlAlias
     *
     * @return IsNull
     */
    public static function isNull($field, ?string $dqlAlias = null): IsNull
    {
        return new IsNull($field, $dqlAlias);
    }

    /**
     * @param Operand|string $field
     * @param string|null    $dqlAlias
     *
     * @return IsNotNull
     */
    public static function isNotNull($field, ?string $dqlAlias = null): IsNotNull
    {
        return new IsNotNull($field, $dqlAlias);
    }

    /**
     * Make sure the $field has a value equals to $value.
     *
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @return In
     */
    public static function in($field, $value, ?string $dqlAlias = null): In
    {
        return new In($field, $value, $dqlAlias);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @return Not
     */
    public static function notIn($field, $value, ?string $dqlAlias = null): Not
    {
        return new Not(new In($field, $value, $dqlAlias));
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @return Equals
     */
    public static function eq($field, $value, ?string $dqlAlias = null): Equals
    {
        return new Equals($field, $value, $dqlAlias);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @return NotEquals
     */
    public static function neq($field, $value, ?string $dqlAlias = null): NotEquals
    {
        return new NotEquals($field, $value, $dqlAlias);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @return LessThan
     */
    public static function lt($field, $value, ?string $dqlAlias = null): LessThan
    {
        return new LessThan($field, $value, $dqlAlias);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @return LessOrEqualThan
     */
    public static function lte($field, $value, ?string $dqlAlias = null): LessOrEqualThan
    {
        return new LessOrEqualThan($field, $value, $dqlAlias);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @return GreaterThan
     */
    public static function gt($field, $value, ?string $dqlAlias = null): GreaterThan
    {
        return new GreaterThan($field, $value, $dqlAlias);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @return GreaterOrEqualThan
     */
    public static function gte($field, $value, ?string $dqlAlias = null): GreaterOrEqualThan
    {
        return new GreaterOrEqualThan($field, $value, $dqlAlias);
    }

    /**
     * @param Operand|string     $field
     * @param LikePattern|string $value
     * @param string             $format
     * @param string|null        $dqlAlias
     *
     * @return Like
     */
    public static function like($field, $value, string $format = Like::CONTAINS, ?string $dqlAlias = null): Like
    {
        return new Like($field, $value, $format, $dqlAlias);
    }

    /**
     * @param string      $value
     * @param string|null $dqlAlias
     *
     * @return InstanceOfX
     */
    public static function instanceOfX($value, ?string $dqlAlias = null): InstanceOfX
    {
        return new InstanceOfX($value, $dqlAlias);
    }

    /**
     * @param Operand|mixed  $value
     * @param Operand|string $field
     * @param string|null    $dqlAlias
     *
     * @return MemberOfX
     */
    public static function memberOfX($value, $field, ?string $dqlAlias = null): MemberOfX
    {
        return new MemberOfX($value, $field, $dqlAlias);
    }

    // Specifications

    /**
     * @param Filter|QueryModifier $spec
     *
     * @return CountOf
     */
    public static function countOf($spec): CountOf
    {
        return new CountOf($spec);
    }

    /**
     * @param Filter $spec
     *
     * @return Having
     */
    public static function having(Filter $spec): Having
    {
        return new Having($spec);
    }

    // Operands

    /**
     * @param string      $fieldName
     * @param string|null $dqlAlias
     *
     * @return Field
     */
    public static function field(string $fieldName, ?string $dqlAlias = null): Field
    {
        return new Field($fieldName, $dqlAlias);
    }

    /**
     * @param mixed           $value
     * @param int|string|null $valueType
     *
     * @return Value
     */
    public static function value($value, $valueType = null): Value
    {
        return new Value($value, $valueType);
    }

    /**
     * @param mixed[]         $values
     * @param int|string|null $valueType
     *
     * @return Values
     */
    public static function values(array $values, $valueType = null): Values
    {
        return new Values($values, $valueType);
    }

    /**
     * @param string $value
     * @param string $format
     *
     * @return LikePattern
     */
    public static function likePattern(string $value, string $format = LikePattern::CONTAINS): LikePattern
    {
        return new LikePattern($value, $format);
    }

    /**
     * @param Operand|string $field
     *
     * @return CountDistinct
     */
    public static function countDistinct($field): CountDistinct
    {
        return new CountDistinct($field);
    }

    // Arithmetic operands

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     *
     * @return Addition
     */
    public static function add($field, $value): Addition
    {
        return new Addition($field, $value);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     *
     * @return Subtraction
     */
    public static function sub($field, $value): Subtraction
    {
        return new Subtraction($field, $value);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     *
     * @return Multiplication
     */
    public static function mul($field, $value): Multiplication
    {
        return new Multiplication($field, $value);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     *
     * @return Division
     */
    public static function div($field, $value): Division
    {
        return new Division($field, $value);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     *
     * @return Modulo
     */
    public static function mod($field, $value): Modulo
    {
        return new Modulo($field, $value);
    }

    /**
     * Call DQL function.
     *
     * Usage:
     *  Spec::fun('CURRENT_DATE')
     *  Spec::fun('DATE_DIFF', $date1, $date2)
     *
     * @param string $functionName
     * @param mixed  ...$arguments
     *
     * @return PlatformFunction
     */
    public static function fun(string $functionName, ...$arguments): PlatformFunction
    {
        return new PlatformFunction($functionName, ...$arguments);
    }

    /**
     * @param string $alias
     *
     * @return Alias
     */
    public static function alias(string $alias): Alias
    {
        return new Alias($alias);
    }
}
