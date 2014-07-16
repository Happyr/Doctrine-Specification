<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class Join
 *
 * @author Tobias Nyholm
 *
 *
 */
class Join implements Specification
{
    /**
     * @var string field
     *
     */
    protected $field;

    /**
     * @var string alias
     *
     */
    protected $alias;

    /**
     * @param string $field
     * @param string $alias
     */
    public function __construct($field, $alias)
    {
        $this->field = $field;
        $this->alias = $alias;
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return \Doctrine\ORM\Query\Expr
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        $qb->join($dqlAlias.'.'.$this->field, $this->alias);
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