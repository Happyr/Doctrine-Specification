<?php

namespace Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Parameter;

/**
 * Round a \DateTime to enable caching.
 */
class RoundDateTime implements ResultModifier
{
    /**
     * @var int How may seconds to round time
     */
    private $roundSeconds;

    /**
     * @param int $roundSeconds How may seconds to round time
     */
    public function __construct($roundSeconds)
    {
        $this->roundSeconds = $roundSeconds;
    }

    /**
     * @param AbstractQuery $query
     */
    public function modify(AbstractQuery $query)
    {
        foreach ($query->getParameters() as $parameter) {
            if ($parameter instanceof Parameter &&
                ($value = $parameter->getValue()) &&
                $value instanceof \DateTimeInterface
            ) {
                // round down so that the results do not include data that should not be there.
                $date = new \DateTimeImmutable('now', $value->getTimezone());
                $date = $date->setTimestamp(floor($date->getTimestamp() / $this->roundSeconds) * $this->roundSeconds);

                $query->setParameter($parameter->getName(), $date, $parameter->getType());
            }
        }
    }
}
