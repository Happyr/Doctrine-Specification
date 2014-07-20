<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface Specification
 *
 * @author Benjamin Eberlei
 */
interface Specification
{
    /**
     * @param QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return Expr
     */
    public function match(QueryBuilder $qb, $dqlAlias);

    /**
     * @param AbstractQuery $query
     */
    public function modifyQuery(AbstractQuery $query);

    /**
     * @param string $className
     *
     * @return bool
     */
    public function supports($className);
}
