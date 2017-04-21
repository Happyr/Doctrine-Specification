<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * This class allows you to use a Specification to query entities.
 */
class EntitySpecificationRepository extends EntityRepository implements EntitySpecificationRepositoryInterface, ObjectRepository, Selectable
{
    use EntitySpecificationRepositoryTrait;
}
