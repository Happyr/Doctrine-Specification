<?php

namespace Happyr\Doctrine\ORM;

use Doctrine\ORM\EntityManagerInterface;

class EntitySpecificationRepositoryFactory implements \Doctrine\ORM\Repository\RepositoryFactory
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
        return new BaseEntitySpecificationRepository($entityManager, $entityManager->getClassMetadata($entityName));
    }
}