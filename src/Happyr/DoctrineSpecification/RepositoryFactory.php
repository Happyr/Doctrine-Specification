<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Factory class for creating \Happyr\DoctrineSpecification\EntitySpecificationRepository instances.
 *
 * Provides an implementation of \Doctrine\ORM\Repository\RepositoryFactory so that the
 * default repository type in Doctrine can easily be replaced.
 *
 * @author Andy Hunt
 */
class RepositoryFactory implements \Doctrine\ORM\Repository\RepositoryFactory
{
    /**
     * Gets the repository for an entity class.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager The EntityManager instance.
     * @param string $entityName The name of the entity.
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository(EntityManagerInterface $entityManager, $entityName)
    {
        return new EntitySpecificationRepository(
            $entityManager,
            $entityManager->getClassMetadata($entityName)
        );
    }
}
