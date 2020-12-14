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

namespace Happyr\DoctrineSpecification\Query\Selection;

use Doctrine\ORM\QueryBuilder;

final class SelectEntity implements Selection
{
    /**
     * @var string
     */
    private $context;

    /**
     * @param string $context
     */
    public function __construct(string $context)
    {
        $this->context = $context;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, string $context): string
    {
        return $this->context;
    }
}
