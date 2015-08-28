<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\EntityRepository;

/**
 * This class allows you to use a Specification to query entities.
 */
class EntitySpecificationRepository extends EntityRepository implements EntitySpecificationRepositoryInterface
{
    use EntitySpecificationRepositoryTrait;
}
