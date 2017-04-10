<?php

namespace Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;

class Cache implements ResultModifier
{
    /**
     * @var int How may seconds the cache entry is valid
     */
    private $cacheLifetime;

    /**
     * @param int $cacheLifetime How many seconds the cached entry is valid
     */
    public function __construct($cacheLifetime)
    {
        $this->cacheLifetime = $cacheLifetime;
    }

    /**
     * @param AbstractQuery $query
     */
    public function modify(AbstractQuery $query)
    {
        $query->setResultCacheLifetime($this->cacheLifetime);
    }
}
