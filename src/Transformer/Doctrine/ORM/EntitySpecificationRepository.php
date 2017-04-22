<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * This class allows you to use a Specification to query entities.
 */
class EntitySpecificationRepository extends EntityRepository implements EntitySpecificationRepositoryInterface, ObjectRepository, Selectable
{
    use EntitySpecificationRepositoryTrait;

    /**
     * @param EntityManager          $em          the EntityManager to use
     * @param ClassMetadata          $class       the class descriptor
     * @param DoctrineORMTransformer $transformer the Specification transformer
     */
    public function __construct($em, ClassMetadata $class, DoctrineORMTransformer $transformer)
    {
        parent::__construct($em, $class);
        $this->setTransformer($transformer);
    }
}
