<?php

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

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Repository\RepositoryFactory as DoctrineRepositoryFactory;
use Happyr\DoctrineSpecification\EntitySpecificationRepository;

/**
 * Factory class for creating EntitySpecificationRepository instances.
 *
 * Provides an implementation of RepositoryFactory so that the
 * default repository type in Doctrine can easily be replaced.
 */
class RepositoryFactory implements DoctrineRepositoryFactory
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
