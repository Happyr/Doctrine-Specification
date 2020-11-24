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

namespace Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Specification\Specification;

class Not implements Specification
{
    /**
     * @var Filter child
     */
    private $child;

    /**
     * @param Filter $expr
     */
    public function __construct(Filter $expr)
    {
        $this->child = $expr;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, $dqlAlias)
    {
        return (string) $qb->expr()->not($this->child->getFilter($qb, $dqlAlias));
    }

    /**
     * @param QueryBuilder $query
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $query, $dqlAlias)
    {
        if ($this->child instanceof QueryModifier) {
            $this->child->modify($query, $dqlAlias);
        }
    }
}
