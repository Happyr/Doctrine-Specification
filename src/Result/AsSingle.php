<?php

namespace Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;

/**
 * Class AsSingle.
 * @deprecated
 */
class AsSingle implements ResultModifier
{
    /**
     * @param AbstractQuery $query
     */
    public function modify(AbstractQuery $query)
    {
        $query->setHydrationMode(Query::HYDRATE_OBJECT);
    }
}
