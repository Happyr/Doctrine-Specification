<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface Specification
 *
 * @author Benjamin Eberlei
 */
interface Specification
{
    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return \Doctrine\ORM\Query\Expr
     */
    public function match(QueryBuilder $qb, $dqlAlias);

    /**
     * @param \Doctrine\ORM\AbstractQuery $query
     */
    public function modifyQuery(AbstractQuery $query);

    /**
     * @param string $className
     * @return bool
     */
    public function supports($className);
}
