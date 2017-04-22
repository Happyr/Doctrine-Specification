<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ODM\MongoDB;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\UnitOfWork;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * This class allows you to use a Specification to query entities.
 */
class EntitySpecificationRepository extends DocumentRepository implements EntitySpecificationRepositoryInterface, ObjectRepository, Selectable
{
    use EntitySpecificationRepositoryTrait;

    /**
     * @param DocumentManager               $dm          the DocumentManager to use
     * @param UnitOfWork                    $uow         the UnitOfWork to use
     * @param ClassMetadata                 $class       the class descriptor
     * @param DoctrineODMMongoDBTransformer $transformer The Specification transformer
     */
    public function __construct(
        DocumentManager $dm,
        UnitOfWork $uow,
        ClassMetadata $class,
        DoctrineODMMongoDBTransformer $transformer
    ) {
        parent::__construct($dm, $uow, $class);
        $this->setTransformer($transformer);
    }
}
