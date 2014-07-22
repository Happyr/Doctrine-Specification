<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Comparison as ExprComparison;

/**
 * Class IsNotNull
 *
 * @author Tobias Nyholm
 *
 *
 */
class IsNotNull implements Specification
{
    /**
     * @var string field
     *
     */
    private $field;

    /**
     * @var null|string dqlAlias
     *
     */
    private $dqlAlias;

    /**
     * Make sure the $field IS NULL
     *
     * @param string $field
     * @param string $dqlAlias
     */
    public function __construct($field, $dqlAlias = null)
    {
        $this->field = $field;
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

        return $qb->expr()->isNotNull(sprintf('%s.%s', $dqlAlias, $this->field));
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
}
