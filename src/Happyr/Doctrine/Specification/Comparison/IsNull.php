<?php

namespace Happyr\Doctrine\Specification\Comparison;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\Doctrine\Specification\Specification;

/**
 * Class IsNull
 *
 * @author Tobias Nyholm
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
     * @param string      $field
     * @param string|null $dqlAlias
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

        return $qb->expr()->isNull(sprintf('%s.%s', $dqlAlias, $this->field));
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
