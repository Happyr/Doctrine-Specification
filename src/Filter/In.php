<?php

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

class In implements Filter
{
    /**
     * @var string field
     */
    protected $field;

    /**
     * @var string value
     */
    protected $value;

    /**
     * @var string dqlAlias
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
    public function getFilter(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        $paramName = $this->getParameterName($qb);
        $qb->setParameter($paramName, $this->value);

        return (string) $qb->expr()->in(
            sprintf('%s.%s', $dqlAlias, $this->field),
            sprintf(':%s', $paramName)
        );
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
        return sprintf('in_%d', $qb->getParameters()->count());
    }
}
