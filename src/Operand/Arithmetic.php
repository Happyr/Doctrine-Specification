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

namespace Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;

abstract class Arithmetic implements Operand
{
    protected const ADD = '+';

    protected const SUB = '-';

    protected const MUL = '*';

    protected const DIV = '/';

    /**
     * @var string[]
     */
    private static $operations = [
        self::ADD,
        self::SUB,
        self::MUL,
        self::DIV,
    ];

    /**
     * @var string
     */
    private $operation;

    /**
     * @var Operand|string
     */
    private $field;

    /**
     * @var Operand|string
     */
    private $value;

    /**
     * @param string         $operation
     * @param Operand|string $field
     * @param Operand|mixed  $value
     */
    public function __construct(string $operation, $field, $value)
    {
        if (!in_array($operation, self::$operations, true)) {
            throw new InvalidArgumentException(sprintf(
                '"%s" is not a valid arithmetic operation. Valid operations are: "%s"',
                $operation,
                implode(', ', self::$operations)
            ));
        }

        $this->operation = $operation;
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, string $context): string
    {
        $field = ArgumentToOperandConverter::toField($this->field);
        $value = ArgumentToOperandConverter::toValue($this->value);

        $field = $field->transform($qb, $context);
        $value = $value->transform($qb, $context);

        return sprintf('(%s %s %s)', $field, $this->operation, $value);
    }

    /**
     * @param mixed[]|object $candidate
     * @param string|null    $context
     *
     * @return mixed
     */
    public function execute($candidate, ?string $context = null)
    {
        $field = ArgumentToOperandConverter::toField($this->field);
        $value = ArgumentToOperandConverter::toValue($this->value);

        return $this->doExecute($field->execute($candidate, $context), $value->execute($candidate, $context));
    }

    /**
     * @param mixed $field
     * @param mixed $value
     *
     * @return mixed
     */
    abstract protected function doExecute($field, $value);
}
