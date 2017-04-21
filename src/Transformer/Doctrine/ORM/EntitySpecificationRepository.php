<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
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
     * @param EntityManager          $em          The EntityManager to use.
     * @param ClassMetadata          $class       The class descriptor.
     * @param DoctrineORMTransformer $transformer The Specification transformer.
     */
    public function __construct($em, ClassMetadata $class, DoctrineORMTransformer $transformer)
    {
        parent::__construct($em, $class);
        $this->setTransformer($transformer);
    }
}