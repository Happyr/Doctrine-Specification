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

namespace Happyr\DoctrineSpecification\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * This class allows you to use a Specification to query entities.
 *
 * @template T of object
 * @phpstan-extends EntityRepository<T>
 */
class EntitySpecificationRepository extends EntityRepository implements EntitySpecificationRepositoryInterface
{
    use EntitySpecificationRepositoryTrait;
}
