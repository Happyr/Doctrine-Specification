<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class Null
 *
 * @author Tobias Nyholm
 *
 *
 */
class Null implements Specification
{
    /**
     * @var string field
     *
     */
    protected $field;

    /**
     * Make sure the $field IS NULL
     *
     * @param string $field
     */
    public function __construct($field)
    {
        $this->field = $field;
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return \Doctrine\ORM\Query\Expr
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        return $qb->expr()->isNotNull(sprintf('%s.%s', $dqlAlias, $this->field));
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