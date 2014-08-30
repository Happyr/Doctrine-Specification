<?php

namespace Happyr\DoctrineSpecification\Comparison;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;
use Happyr\DoctrineSpecification\Specification;

/**
 * Comparison class
 *
 * This is used when you need to compare two values
 *
 * @author Tobias Nyholm
 */
class Comparison implements Specification
{
    const EQ = '=';
    const NEQ = '<>';
    const LT = '<';
    const LTE = '<=';
    const GT = '>';
    const GTE = '>=';
    const LIKE = 'LIKE';

    private static $operators = array(
        self::EQ, self::NEQ,
        self::LT, self::LTE,
        self::GT, self::GTE,
        self::LIKE
    );

    /**
     * @var string field
     *
     */
    protected $field;

    /**
     * @var string value
     *
     */
    protected $value;

    /**
     * @var string dqlAlias
     *
     */
    protected $dqlAlias;
    /**
     * @var string
     */
    private $operator;

    /**
     * Make sure the $field has a value equals to $value
     *
     * @param string $operator
     * @param string $field
     * @param string $value
     * @param string $dqlAlias
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($operator, $field, $value, $dqlAlias = null)
    {
        if (!in_array($operator, self::$operators)) {
            throw new \InvalidArgumentException(
                sprintf('"%s" is not a valid comparison operator. Valid operators are: "%s"',
                        $operator,
                        implode(',', self::$operators)
                )
            );
        }

        $this->operator = $operator;
        $this->field = $field;
        $this->value = $value;
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return Expr
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        $paramName = $this->getParameterName($qb);
        $qb->setParameter($paramName, $this->value);

        return new DoctrineComparison(
            sprintf('%s.%s', $dqlAlias, $this->field),
            $this->operator,
            sprintf(':%s', $paramName)
        );
    }

    /**
     * @param AbstractQuery $query
     */
    public function modifyQuery(AbstractQuery $query)
    {
    }

    /**
     * @param string $className
     *
     * @return bool
     */
    public function supports($className)
    {
        return true;
    }

    /**
     * Get a good unique parameter name
     *
     * @param QueryBuilder $qb
     *
     * @return string
     */
    protected function getParameterName(QueryBuilder $qb)
    {
        return sprintf('comparison_%d', $qb->getParameters()->count());
    }
}
