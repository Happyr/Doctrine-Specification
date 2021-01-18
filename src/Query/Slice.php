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

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;

final class Slice implements QueryModifier
{
    /**
     * @var int
     */
    private $sliceSize;

    /**
     * @var int
     */
    private $sliceNumber = 0;

    /**
     * @param int $sliceSize
     * @param int $sliceNumber
     */
    public function __construct(int $sliceSize, int $sliceNumber = 0)
    {
        $this->sliceSize = $sliceSize;
        $this->sliceNumber = $sliceNumber;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     */
    public function modify(QueryBuilder $qb, string $context): void
    {
        $qb->setMaxResults($this->sliceSize);

        if ($this->sliceNumber > 0) {
            $qb->setFirstResult($this->sliceNumber * $this->sliceSize);
        }
    }
}
