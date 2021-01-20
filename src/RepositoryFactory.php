<?php

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

namespace Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Repository\RepositoryFactory as BaseRepositoryFactory;

@trigger_error('The '.__NAMESPACE__.'\RepositoryFactory class is deprecated since version 1.1 and will be removed in 2.0, use \Happyr\DoctrineSpecification\Repository\RepositoryFactory instead.', E_USER_DEPRECATED);

/**
 * Factory class for creating EntitySpecificationRepository instances.
 *
 * Provides an implementation of RepositoryFactory so that the
 * default repository type in Doctrine can easily be replaced.
 *
 * @description This class is deprecated since version 1.1 and will be removed in 2.0, use \Happyr\DoctrineSpecification\Repository\RepositoryFactory instead.
 */
class RepositoryFactory extends BaseRepositoryFactory
{
}
