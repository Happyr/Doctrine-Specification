<?php

namespace Happyr\DoctrineSpecification\Where\Comparison;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Specification;

/**
 * @author Tobias Nyholm
 */
class In implements Specification
{
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
     * Make sure the $field has a value equals to $value
     *
     * @param string $field
     * @param string $value
     * @param string $dqlAlias
     */
    public function __construct($field, $value, $dqlAlias = null)
    {
        $this->field = $field;
        $this->value = $value;
        $this->dqlAlias = $dqlAlias;
    }


    /**
     * @param QueryBuilder $qb
     * @param string $dqlAlias
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

        return $qb->expr()->in(
            sprintf('%s.%s', $dqlAlias, $this->field),
            sprintf(':%s', $paramName)
        );
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
    private function getParameterName(QueryBuilder $qb)
    {
        return sprintf('in_%d', $qb->getParameters()->count());
    }
}
