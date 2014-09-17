<?php

namespace Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Happyr\DoctrineSpecification\Specification;

/**
 * Class AsArray
 */
class AsArray implements Modifier
{
    /**
     * @var Specification parent
     */
    private $parent;

    /**
     * @param Specification $parent
     */
    public function __construct(Specification $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @param AbstractQuery $query
     */
    public function modify(AbstractQuery $query)
    {
        $query->setHydrationMode(Query::HYDRATE_ARRAY);
    }
}
