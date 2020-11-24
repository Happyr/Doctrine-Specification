<?php
declare(strict_types=1);

/**
 * This file is part of the Happyr Doctrine Specification package.
 *
 * (c) Tobias Nyholm <tobias@happyr.com>
 *     Kacper Gunia <kacper@gunia.me>
 *     Peter Gribanov <info@peter-gribanov.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
                $uts = (int) (floor($value->getTimestamp() / $this->roundSeconds) * $this->roundSeconds);
                $date = (new \DateTimeImmutable('now', $value->getTimezone()))->setTimestamp($uts);

                $query->setParameter($parameter->getName(), $date, $parameter->getType());
            }
        }
    }
}
