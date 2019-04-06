<?php

namespace Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;

class PlatformFunction implements Operand
{
    /**
     * @var string[]
     */
    private static $doctrineFunctions = [
        'IDENTITY',
        'ABS',
        'CONCAT',
        'CURRENT_DATE',
        'CURRENT_TIME',
        'CURRENT_TIMESTAMP',
        'LENGTH',
        'LOCATE',
        'LOWER',
        'MOD',
        'SIZE',
        'SQRT',
        'SUBSTRING',
        'TRIM',
        'UPPER',
        'DATE_ADD',
        'DATE_SUB',
        'DATE_DIFF',
    ];

    /**
     * @var string
     */
    private $functionName = '';

    /**
     * @var array
     */
    private $arguments = [];

    /**
     * @param string $functionName
     * @param mixed  $arguments
     */
    public function __construct($functionName, $arguments = [])
    {
        if (2 === func_num_args()) {
            $this->functionName = $functionName;
            $this->arguments = (array) $arguments;
        } else {
            $arguments = func_get_args();
            $this->functionName = array_shift($arguments);
            $this->arguments = $arguments;
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, $dqlAlias)
    {
        if (!in_array(strtoupper($this->functionName), self::$doctrineFunctions) &&
            !$qb->getEntityManager()->getConfiguration()->getCustomStringFunction($this->functionName) &&
            !$qb->getEntityManager()->getConfiguration()->getCustomNumericFunction($this->functionName) &&
            !$qb->getEntityManager()->getConfiguration()->getCustomDatetimeFunction($this->functionName)
        ) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid function name.', $this->functionName));
        }

        $arguments = ArgumentToOperandConverter::convert($this->arguments);
        foreach ($arguments as $key => $argument) {
            $arguments[$key] = $argument->transform($qb, $dqlAlias);
        }

        return sprintf('%s(%s)', $this->functionName, implode(', ', $arguments));
    }
}
