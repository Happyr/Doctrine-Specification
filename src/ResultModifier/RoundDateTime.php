<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\ResultModifier;

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
     * @return int
     */
    public function getRoundSeconds()
    {
        return $this->roundSeconds;
    }
}
