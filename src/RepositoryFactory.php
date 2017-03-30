<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Factory class for creating EntitySpecificationRepository instances.
 *
 * Provides an implementation of RepositoryFactory so that the
 * default repository type in Doctrine can easily be replaced.
 */
class RepositoryFactory implements \Doctrine\ORM\Repository\RepositoryFactory
{
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
            $entityManager->getClassMetadata($entityName)
        );
    }
}
