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

namespace Happyr\DoctrineSpecification\Specification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;

class CountOf implements Specification
{
    /**
     * @var Filter|QueryModifier
     */
    private $child;

    /**
     * @param Filter|QueryModifier $child
     */
    public function __construct($child)
    {
        $this->child = $child;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, string $dqlAlias): string
    {
        $qb->select(sprintf('COUNT(%s)', $dqlAlias));

        if ($this->child instanceof Filter) {
            return $this->child->getFilter($qb, $dqlAlias);
        }

        return '';
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, string $dqlAlias): void
    {
        if ($this->child instanceof QueryModifier) {
            $this->child->modify($qb, $dqlAlias);
        }
    }
}
