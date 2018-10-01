<?php

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\QueryBuilder;

class Size implements Filter
{
    /**
     * @var null|string dqlAlias
     */
    protected $dqlAlias;

    /**
     * @var string field
     */
    protected $field;

    /**
     * @var string value
     */
    protected $value;
    /**
     * @var string
     */
    private $operator;

    /**
     * @param string      $field
     * @param string      $operator
     * @param string      $value
     * @param string|null $dqlAlias
     */
    public function __construct($field, $operator, $value, $dqlAlias = null)
    {
        $this->dqlAlias = $dqlAlias;
        $this->value = $value;
        $this->field = $field;
        $this->operator = $operator;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, $dqlAlias)
    {
        $leftExpr = sprintf('size(%s.%s)', $dqlAlias, $this->field);
        $rightExpr = $this->value;
        $operator = $this->operator;
        return new \Doctrine\ORM\Query\Expr\Comparison($leftExpr, $operator, $rightExpr);
    }
}