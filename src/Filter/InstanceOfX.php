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

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\DQLContextResolver;

final class InstanceOfX implements Filter, Satisfiable
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var string|null
     */
    private $context;

    /**
     * @param string      $value
     * @param string|null $context
     */
    public function __construct(string $value, ?string $context = null)
    {
        $this->value = $value;
        $this->context = $context;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, string $context): string
    {
        if (null !== $this->context) {
            $context = sprintf('%s.%s', $context, $this->context);
        }

        $dqlAlias = DQLContextResolver::resolveAlias($qb, $context);

        return (string) $qb->expr()->isInstanceOf($dqlAlias, $this->value);
    }

    /**
     * {@inheritdoc}
     */
    public function filterCollection(iterable $collection, ?string $context = null): iterable
    {
        foreach ($collection as $candidate) {
            if ($candidate instanceof $this->value) {
                yield $candidate;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy($candidate, ?string $context = null): bool
    {
        return $candidate instanceof $this->value;
    }
}
