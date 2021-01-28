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
use Happyr\DoctrineSpecification\DQLContextResolver;

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
     * @param string|null $newAlias
     * @param string|null $context
     */
    public function __construct(string $field, ?string $newAlias = null, ?string $context = null)
    {
        $this->field = $field;
        $this->newAlias = null !== $newAlias ? $newAlias : $field;
        $this->context = $context;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     */
    public function modify(QueryBuilder $qb, string $context): void
    {
        if (null !== $this->context) {
            $context = sprintf('%s.%s', $context, $this->context);
        }

        $dqlAlias = DQLContextResolver::resolveAlias($qb, $context);

        $this->modifyJoin($qb, sprintf('%s.%s', $dqlAlias, $this->field), $this->newAlias);
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $join
     * @param string       $alias
     */
    abstract protected function modifyJoin(QueryBuilder $qb, string $join, string $alias): void;
}
