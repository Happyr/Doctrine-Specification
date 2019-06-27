<?php

namespace Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;

abstract class Bitwise implements Operand
{
    const B_AND = '&';

    const B_OR = '|';

    const B_XOR = '^';

    const B_LS = '<<';

    const B_RS = '>>';

    /**
     * @var string[]
     */
    private static $operations = array(
        self::B_AND,
        self::B_OR,
    );

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
                '"%s" is not a valid bitwise operation. Valid operations are: "%s"',
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
        $function = self::B_AND === $this->operation ? 'BIT_AND' : 'BIT_OR';

        return (new PlatformFunction($function, $this->field, $this->value))->transform($qb, $dqlAlias);
    }
}
