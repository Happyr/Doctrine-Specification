# Integrating with frameworks - Zend 1
## Replacing the default repository type
Doctrine integration with Zend Framework 1 is done manually. However, replacing the default repository type is still simple. In the bootstrap (or wherever Doctrine is configured in the system in question),use Doctrine configruations `setRepositoryFactory` and provide an implementation of `\Doctrine\ORM\Repository\RepositoryFactory`.

```php
// During doctrine configuration
$config->setRepositoryFactory(new My_Repository_Factory());

// My/Repostiory/Factory.php
class My_Repository_Factory implements \Doctrine\ORM\RepositoryFactory
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
        return new My_Repository_BaseEntitySpecificationRepository($entityManager, $entityManager->getClassMetadata($entityName));
    }    
}

// My/Repository/BaseEntitySpecificationRepository
class My_Repository_BaseEntitySpecificationRepository extends \Happyr\Doctrine\Specification\EntitySpecificationRepository
{
    // Implements nothing extra.
    // Merely provides a concrete instance of \Happyr\Doctrine\Specification\EntitySpecificationRepository
    // to use with \Happyr\Doctrime\ORM\EntitySpecificationRepositoryFactory
}
```
