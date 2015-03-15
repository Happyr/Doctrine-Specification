<?php

namespace Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;

/**
 * Class AsArray.
 */
class AsArray implements ResultModifier
{
    /**
     * @param AbstractQuery $query
     */
    public function modify(AbstractQuery $query)
    {
        $query->setHydrationMode(Query::HYDRATE_ARRAY);
    }
}
