<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Comparison as ExprComparison;

/**
 * Abstract class Comparison
 *
 * This is used when you should compare two values
 *
 * @author Tobias Nyholm
 *
 */
abstract class Comparison implements Specification
{
    use ParameterNameTrait;

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
     * Make sure the $field has a value equals to $value
     *
     * @param string $field
     * @param string $value
     */
    public function __construct($field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * Returns one of the const for Doctrine\ORM\Query\Expr\Comparison
     *
     * @return string
     */
    abstract protected function getComparisonExpression();

    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return \Doctrine\ORM\Query\Expr
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        $paramName=$this->getParameterName($qb);
        $qb->setParameter($paramName, $this->value);

        return new ExprComparison(
            sprintf('%s.%s', $dqlAlias, $this->field),
            $this->getComparisonExpression(),
            ':'.$paramName
        );
    }

    /**
     * @param \Doctrine\ORM\AbstractQuery $query
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
}