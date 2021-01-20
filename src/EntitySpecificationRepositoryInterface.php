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

namespace Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Repository\EntitySpecificationRepositoryInterface as BaseEntitySpecificationRepositoryInterface;

@trigger_error('The '.__NAMESPACE__.'\EntitySpecificationRepositoryInterface class is deprecated since version 1.1 and will be removed in 2.0, use \Happyr\DoctrineSpecification\Repository\EntitySpecificationRepositoryInterface instead.', E_USER_DEPRECATED);

/**
 * This interface should be used by an EntityRepository implementing the Specification pattern.
 *
 * @description This class is deprecated since version 1.1 and will be removed in 2.0, use \Happyr\DoctrineSpecification\Repository\EntitySpecificationRepositoryInterface instead.
 */
interface EntitySpecificationRepositoryInterface extends BaseEntitySpecificationRepositoryInterface
{
}
