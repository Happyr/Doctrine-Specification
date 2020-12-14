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
    private $context;

    /**
     * @param string      $field
     * @param string      $newAlias
     * @param string|null $context
     */
    public function __construct(string $field, string $newAlias, ?string $context = null)
    {
        $this->field = $field;
        $this->newAlias = $newAlias;
        $this->context = $context;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     */
    public function modify(QueryBuilder $qb, string $context): void
    {
        if (null !== $this->context) {
            $context = $this->context;
        }

        $this->modifyJoin($qb, sprintf('%s.%s', $context, $this->field), $this->newAlias);
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $join
     * @param string       $alias
     */
    abstract protected function modifyJoin(QueryBuilder $qb, string $join, string $alias): void;
}
