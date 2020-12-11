<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
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
     * @param array|object $candidate
     *
     * @return bool
     */
    public function isSatisfiedBy($candidate): bool;
}
