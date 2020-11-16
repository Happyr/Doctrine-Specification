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
    const ADD = '+';

    const SUB = '-';

    const MUL = '*';

    const DIV = '/';

    const MOD = '%';

    /**
     * @var string[]
     */
    private static $operations = [
        self::ADD,
        self::SUB,
        self::MUL,
        self::DIV,
        self::MOD,
    ];

    /**
     * @var string
     */
    private $operation = '';

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
     * @param Operand|string $value
     */
    public function __construct($operation, $field, $value)
    {
        if (!in_array($operation, self::$operations)) {
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
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, $dqlAlias)
    {
        $field = ArgumentToOperandConverter::toField($this->field);
        $value = ArgumentToOperandConverter::toValue($this->value);

        $field = $field->transform($qb, $dqlAlias);
        $value = $value->transform($qb, $dqlAlias);

        return sprintf('(%s %s %s)', $field, $this->operation, $value);
    }
}
