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
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;

final class QueryModifierCollection implements QueryModifier
{
    /**
     * @var QueryModifier[]
     */
    private $children;

    /**
     * Construct it with one or more instances of QueryModifier.
     *
     * @param QueryModifier ...$children
     */
    public function __construct(...$children)
    {
        $this->children = $children;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     */
    public function modify(QueryBuilder $qb, string $context): void
    {
        foreach ($this->children as $child) {
            if (!$child instanceof QueryModifier) {
                throw new InvalidArgumentException(sprintf(
                    'Child passed to QueryModifierCollection must be an instance of %s, but instance of %s found',
                    QueryModifier::class,
                    get_class($child)
                ));
            }

            $child->modify($qb, $context);
        }
    }
}
