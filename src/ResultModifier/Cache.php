<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\ResultModifier;

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
     * @return int
     */
    public function getCacheLifetime()
    {
        return $this->cacheLifetime;
    }
}
