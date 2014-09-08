<?php

namespace Happyr\DoctrineSpecification\QueryOption;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Happyr\DoctrineSpecification\QueryOption;

class AsArray implements QueryOption
{

    /**
     * setHydrationMode
     * setLimit
     * setOffset
     * setCacheDriver
     * setCacheLifetime
     * setUseCache
     */
    /**
     * @param Query $query
     */
    public function modifyQuery(Query $query)
    {
        $query->setHydrationMode(Query::HYDRATE_ARRAY);
    }
}
