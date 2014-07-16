<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class IsNull
 *
 * @author Tobias Nyholm
 *
 *
 */
class IsNull implements Specification
{
    /**
     * @var string field
     *
     */
    protected $field;

    /**
     * @var null|string dqlAlias
     *
     */
    private $dqlAlias;

    /**
     * Make sure the $field IS NULL
     *
     * @param string $field
     */
    public function __construct($field, $dqlAlias = null)
    {
        $this->field = $field;
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return \Doctrine\ORM\Query\Expr
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        return $qb->expr()->isNull(sprintf('%s.%s', $dqlAlias, $this->field));
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