<?php

namespace Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Parameter;

class Cache implements ResultModifier
{
    /**
     * @var int How may seconds the cache entry is valid
     */
    private $cacheLifetime;

    /**
     * @var bool Round DateTime in query params
     */
    private $round;

    /**
     * @param int  $cacheLifetime How many seconds the cached entry is valid
     * @param bool $round         Round DateTime in query params
     */
    public function __construct($cacheLifetime, $round = true)
    {
        $this->cacheLifetime = $cacheLifetime;
        $this->round = $round;
    }

    /**
     * @param AbstractQuery $query
     */
    public function modify(AbstractQuery $query)
    {
        // round date params to cache lifetime
        if ($this->round) {
            foreach ($query->getParameters() as $parameter) {
                /* @var $parameter Parameter */
                if ($parameter->getValue() instanceof \DateTime) {
                    // round down so that the results do not include data that should not be there.
                    $date = clone $parameter->getValue();
                    $date->setTimestamp(floor($date->getTimestamp() / $this->cacheLifetime) * $this->cacheLifetime);

                    $query->setParameter($parameter->getName(), $date, $parameter->getType());
                }
            }
        }

        $query->setResultCacheLifetime($this->cacheLifetime);
    }
}
