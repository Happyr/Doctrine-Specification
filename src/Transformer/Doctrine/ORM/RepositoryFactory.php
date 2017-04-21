<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Repository\RepositoryFactory as DoctrineRepositoryFactory;

/**
 * Factory class for creating EntitySpecificationRepository instances.
 *
 * Provides an implementation of RepositoryFactory so that the
 * default repository type in Doctrine can easily be replaced.
 */
class RepositoryFactory implements DoctrineRepositoryFactory
{
    /**
     * @var DoctrineORMTransformer
     */
    private $transformer;

    /**
     * @param DoctrineORMTransformer $transformer
     */
    public function __construct(DoctrineORMTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Gets the repository for an entity class.
     *
     * @param EntityManagerInterface $entityManager the EntityManager instance
     * @param string                 $entityName    the name of the entity
     *
     * @return EntityRepository
     */
    public function getRepository(EntityManagerInterface $entityManager, $entityName)
    {
        return new EntitySpecificationRepository(
            $entityManager,
            $entityManager->getClassMetadata($entityName),
            $this->transformer
        );
    }
}
