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

use Happyr\DoctrineSpecification\Filter\Comparison;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Filter\In;
use Happyr\DoctrineSpecification\Filter\InstanceOfX;
use Happyr\DoctrineSpecification\Filter\IsNotNull;
use Happyr\DoctrineSpecification\Filter\IsNull;
use Happyr\DoctrineSpecification\Filter\Like;
use Happyr\DoctrineSpecification\Filter\MemberOfX;
use Happyr\DoctrineSpecification\Logic\AndX;
use Happyr\DoctrineSpecification\Logic\Not;
use Happyr\DoctrineSpecification\Logic\OrX;
use Happyr\DoctrineSpecification\Operand\Addition;
use Happyr\DoctrineSpecification\Operand\Alias;
use Happyr\DoctrineSpecification\Operand\BitAnd;
use Happyr\DoctrineSpecification\Operand\BitLeftShift;
use Happyr\DoctrineSpecification\Operand\BitNot;
use Happyr\DoctrineSpecification\Operand\BitOr;
use Happyr\DoctrineSpecification\Operand\BitRightShift;
use Happyr\DoctrineSpecification\Operand\BitXor;
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
use Happyr\DoctrineSpecification\Query\Slice;
use Happyr\DoctrineSpecification\Result\AsArray;
use Happyr\DoctrineSpecification\Result\AsScalar;
use Happyr\DoctrineSpecification\Result\AsSingleScalar;
use Happyr\DoctrineSpecification\Result\Cache;
use Happyr\DoctrineSpecification\Result\RoundDateTime;
use Happyr\DoctrineSpecification\Specification\CountOf;
use Happyr\DoctrineSpecification\Specification\Having;

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
 * @method static PlatformFunction MOD($a, $b) Return a MOD b.
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
     * @param string $name
     * @param array  $arguments
     *
     * @return PlatformFunction
     */
    public static function __callStatic($name, array $arguments = [])
    {
        // allow use array in arguments of static function
        // Spec::DATE_DIFF([$date1, $date2]);
        // is equal
        // Spec::DATE_DIFF($date1, $date2);
        if (1 === count($arguments) && is_array(current($arguments))) {
            $arguments = current($arguments);
        }

        return self::fun($name, $arguments);
    }

    /**
     * Logic.
     */

    /**
     * @return AndX
     */
    public static function andX()
    {
        // NEXT_MAJOR: use variable-length argument lists (...$specs)
        $spec = (new \ReflectionClass(AndX::class))->newInstanceArgs(func_get_args());

        // hook for PHPStan
        if (!($spec instanceof AndX)) {
            throw new \RuntimeException(
                sprintf('The specification must be an instance of "%s", but got "%s".', AndX::class, get_class($spec))
            );
        }

        return $spec;
    }

    /**
     * @return OrX
     */
    public static function orX()
    {
        // NEXT_MAJOR: use variable-length argument lists (...$specs)
        $spec = (new \ReflectionClass(OrX::class))->newInstanceArgs(func_get_args());

        // hook for PHPStan
        if (!($spec instanceof OrX)) {
            throw new \RuntimeException(
                sprintf('The specification must be an instance of "%s", but got "%s".', OrX::class, get_class($spec))
            );
        }

        return $spec;
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

    /**
     * Query modifier.
     */

    /**
     * @param string      $field
     * @param string      $newAlias
     * @param string|null $dqlAlias
     *
     * @return Join
     */
    public static function join($field, $newAlias, $dqlAlias = null)
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
    public static function leftJoin($field, $newAlias, $dqlAlias = null)
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
    public static function innerJoin($field, $newAlias, $dqlAlias = null)
    {
        return new InnerJoin($field, $newAlias, $dqlAlias);
    }

    /**
     * @param Field|string $field
     * @param string|null  $dqlAlias
     *
     * @return IndexBy
     */
    public static function indexBy($field, $dqlAlias = null)
    {
        return new IndexBy($field, $dqlAlias);
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
     * @param Field|Alias|string $field
     * @param string             $order
     * @param string|null        $dqlAlias
     *
     * @return OrderBy
     */
    public static function orderBy($field, $order = 'ASC', $dqlAlias = null)
    {
        return new OrderBy($field, $order, $dqlAlias);
    }

    /**
     * @param Field|Alias|string $field
     * @param string|null        $dqlAlias
     *
     * @return GroupBy
     */
    public static function groupBy($field, $dqlAlias = null)
    {
        return new GroupBy($field, $dqlAlias);
    }

    /**
     * @return Distinct
     */
    public static function distinct()
    {
        return new Distinct();
    }

    /**
     * Selection.
     */

    /**
     * @param mixed $field
     *
     * @return Select
     */
    public static function select($field)
    {
        // NEXT_MAJOR: use variable-length argument lists (...$fields)
        return new Select(func_get_args());
    }

    /**
     * @param mixed $field
     *
     * @return AddSelect
     */
    public static function addSelect($field)
    {
        // NEXT_MAJOR: use variable-length argument lists (...$fields)
        return new AddSelect(func_get_args());
    }

    /**
     * @param string $dqlAlias
     *
     * @return SelectEntity
     */
    public static function selectEntity($dqlAlias)
    {
        return new SelectEntity($dqlAlias);
    }

    /**
     * @param Filter|Operand|string $expression
     * @param string                $alias
     *
     * @return SelectAs
     */
    public static function selectAs($expression, $alias)
    {
        return new SelectAs($expression, $alias);
    }

    /**
     * @param Filter|Operand|string $expression
     * @param string                $alias
     *
     * @return SelectHiddenAs
     */
    public static function selectHiddenAs($expression, $alias)
    {
        return new SelectHiddenAs($expression, $alias);
    }

    /**
     * Result modifier.
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
     * @return AsScalar
     */
    public static function asScalar()
    {
        return new AsScalar();
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

    /**
     * Filters.
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
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $dqlAlias
     *
     * @return In
     */
    public static function in($field, $value, $dqlAlias = null)
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
     * @param Operand|string     $field
     * @param LikePattern|string $value
     * @param string             $format
     * @param string|null        $dqlAlias
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

    /**
     * @param Operand|string $value
     * @param Operand|string $field
     * @param string|null    $dqlAlias
     *
     * @return MemberOfX
     */
    public static function memberOfX($value, $field, $dqlAlias = null)
    {
        return new MemberOfX($value, $field, $dqlAlias);
    }

    /**
     * Specifications.
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
     * @param Filter|QueryModifier|string $spec
     *
     * @return Having
     */
    public static function having($spec)
    {
        if (!($spec instanceof Filter)) {
            @trigger_error('Using "'.(is_object($spec) ? get_class($spec) : gettype($spec)).'" as argument in '.__METHOD__.' method is deprecated since version 1.1 and will not be possible in 2.0.', E_USER_DEPRECATED);
        }

        // NEXT_MAJOR: use here \Happyr\DoctrineSpecification\Query\Having

        return new Having($spec);
    }

    /**
     * Operands.
     */

    /**
     * @param string      $fieldName
     * @param string|null $dqlAlias
     *
     * @return Field
     */
    public static function field($fieldName, $dqlAlias = null)
    {
        return new Field($fieldName, $dqlAlias);
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

    /**
     * @param Operand|string $field
     *
     * @return CountDistinct
     */
    public static function countDistinct($field)
    {
        return new CountDistinct($field);
    }

    /**
     * Arithmetic operands.
     */

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     *
     * @return Addition
     */
    public static function add($field, $value)
    {
        return new Addition($field, $value);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     *
     * @return Subtraction
     */
    public static function sub($field, $value)
    {
        return new Subtraction($field, $value);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     *
     * @return Multiplication
     */
    public static function mul($field, $value)
    {
        return new Multiplication($field, $value);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     *
     * @return Division
     */
    public static function div($field, $value)
    {
        return new Division($field, $value);
    }

    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     *
     * @return Modulo
     */
    public static function mod($field, $value)
    {
        return new Modulo($field, $value);
    }

    /**
     * Bitwise operands.
     */

    /**
     * @deprecated This method is deprecated since version 1.1 and will be removed in 2.0, use "Spec::BIT_AND($a, $b)" instead.
     *
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
     * @deprecated This method is deprecated since version 1.1 and will be removed in 2.0, use "Spec::BIT_OR($a, $b)" instead.
     *
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
     * @deprecated This method is deprecated since version 1.1 and will be removed in 2.0.
     *
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
     * @deprecated This method is deprecated since version 1.1 and will be removed in 2.0.
     *
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
     * @deprecated This method is deprecated since version 1.1 and will be removed in 2.0.
     *
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
     * @deprecated This method is deprecated since version 1.1 and will be removed in 2.0.
     *
     * @param Operand|string $field
     *
     * @return BitNot
     */
    public static function bNot($field)
    {
        return new BitNot($field);
    }

    /**
     * Call DQL function.
     *
     * Usage:
     *  Spec::fun('CURRENT_DATE')
     *  Spec::fun('DATE_DIFF', $date1, $date2)
     *  Spec::fun('DATE_DIFF', [$date1, $date2])
     *
     * @param string $functionName
     * @param mixed  $arguments
     *
     * @return PlatformFunction
     */
    public static function fun($functionName, $arguments = [])
    {
        // NEXT_MAJOR: use variable-length argument lists ($functionName, ...$arguments)
        if (2 === func_num_args()) {
            $arguments = (array) $arguments;
        } else {
            $arguments = func_get_args();
            $functionName = array_shift($arguments);
        }

        return new PlatformFunction($functionName, $arguments);
    }

    /**
     * @param string $alias
     *
     * @return Alias
     */
    public static function alias($alias)
    {
        return new Alias($alias);
    }
}
