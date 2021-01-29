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

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\Operand;

/**
 * Comparison class.
 *
 * This is used when you need to compare two values
 */
abstract class Comparison implements Filter, Satisfiable
{
    protected const EQ = '=';

    protected const NEQ = '<>';

    protected const LT = '<';

    protected const LTE = '<=';

    protected const GT = '>';

    protected const GTE = '>=';

    /**
     * @var Operand|string
     */
    private $field;

    /**
     * @var Operand|string
     */
    private $value;

    /**
     * @var string|null
     */
    private $context;

    /**
     * @var string[]
     */
    private static $operators = [
        self::EQ, self::NEQ,
        self::LT, self::LTE,
        self::GT, self::GTE,
    ];

    /**
     * @var string
     */
    private $operator;

    /**
     * Make sure the $field has a value equals to $value.
     *
     * @param string         $operator
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $context
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $operator, $field, $value, ?string $context = null)
    {
        if (!in_array($operator, self::$operators, true)) {
            throw new InvalidArgumentException(sprintf(
                '"%s" is not a valid comparison operator. Valid operators are: "%s"',
                $operator,
                implode(', ', self::$operators)
            ));
        }

        $this->operator = $operator;
        $this->field = $field;
        $this->value = $value;
        $this->context = $context;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, string $context): string
    {
        if (null !== $this->context) {
            $context = sprintf('%s.%s', $context, $this->context);
        }

        $field = ArgumentToOperandConverter::toField($this->field);
        $value = ArgumentToOperandConverter::toValue($this->value);

        return (string) new DoctrineComparison(
            $field->transform($qb, $context),
            $this->operator,
            $value->transform($qb, $context)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function filterCollection(iterable $collection, ?string $context = null): iterable
    {
        $context = $this->resolveContext($context);
        $field = ArgumentToOperandConverter::toField($this->field);
        $value = ArgumentToOperandConverter::toValue($this->value);

        foreach ($collection as $candidate) {
            if ($this->compare($field->execute($candidate, $context), $value->execute($candidate, $context))) {
                yield $candidate;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy($candidate, ?string $context = null): bool
    {
        $context = $this->resolveContext($context);
        $field = ArgumentToOperandConverter::toField($this->field);
        $value = ArgumentToOperandConverter::toValue($this->value);

        return $this->compare($field->execute($candidate, $context), $value->execute($candidate, $context));
    }

    /**
     * @param string|null $context
     *
     * @return string|null
     */
    private function resolveContext(?string $context): ?string
    {
        if (null !== $this->context && null !== $context) {
            return sprintf('%s.%s', $context, $this->context);
        }

        if (null !== $this->context) {
            return $this->context;
        }

        return $context;
    }

    /**
     * @param mixed $field
     * @param mixed $value
     *
     * @return bool
     */
    abstract protected function compare($field, $value): bool;
}
