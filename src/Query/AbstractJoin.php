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

/**
 * @author Tobias Nyholm
 */
abstract class AbstractJoin implements QueryModifier
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $newAlias;

    /**
     * @var string|null
     */
    private $dqlAlias;

    /**
     * @param string      $field
     * @param string      $newAlias
     * @param string|null $dqlAlias
     */
    public function __construct($field, $newAlias, $dqlAlias = null)
    {
        $this->field = $field;
        $this->newAlias = $newAlias;
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if (null !== $this->dqlAlias) {
            $dqlAlias = $this->dqlAlias;
        }

        $this->modifyJoin($qb, sprintf('%s.%s', $dqlAlias, $this->field), $this->newAlias);
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $join
     * @param string       $alias
     */
    abstract protected function modifyJoin(QueryBuilder $qb, $join, $alias): void;
}
