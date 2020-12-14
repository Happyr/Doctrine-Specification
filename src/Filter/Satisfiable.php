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

interface Satisfiable
{
    /**
     * @param iterable $collection
     *
     * @return iterable
     *
     * @phpstan-template T
     * @phpstan-param iterable<T> $collection
     * @phpstan-return iterable<T>
     */
    public function filterCollection(iterable $collection): iterable;

    /**
     * @param mixed[]|object $candidate
     *
     * @return bool
     */
    public function isSatisfiedBy($candidate): bool;
}
