<?php

namespace Happyr\DoctrineSpecification\Result;

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
     * @param Query $query
     */
    public function modify(Query $query)
    {
        $query->setHydrationMode(Query::HYDRATE_ARRAY);
    }
}
