<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * This class allows you to use a Specification to query entities.
 */
class EntitySpecificationRepository extends EntityRepository implements
    EntitySpecificationRepositoryInterface
    ObjectRepository,
    Selectable
{
    use EntitySpecificationRepositoryTrait;
}
