# Integrating with frameworks - Zend 2
## Replacing the default repository type
Doctrine integration with Zend Framework 2 can be achieved using the `DoctrineORM` bundle. This bundle contains configuration options for the repository factory. To replace the default repository type, provide a concrete implementation of the abstract `\Happyr\Doctrine\Specification\EntitySpecificationRepository` and the necessary configruation options.

```php
// DoctrineORM bundle configruation
array(
   'doctrine' => array(
        'orm_default' => array(
            'repository_factory' => 'happyr.doctrine.specification.repository'
        )
    ),

    'service_manager' => array(
        'factories' => array(
            'happyr.doctrine.specification.repository' => function($sm){
                return new \My\Repository\BaseEntitySpecificationRepository();   
            }
        )
    )
);

// My/Repository/BaseEntitySpecificationRepository.php
namespace My\Repository;

class BaseEntitySpecificationRepository extends \Happyr\Doctrine\Specification\EntitySpecificationRepository
{
    // Implements nothing extra.
    // Merely provides a concrete instance of \Happyr\Doctrine\Specification\EntitySpecificationRepository
    // to use with \Happyr\Doctrime\ORM\EntitySpecificationRepositoryFactory
}
```
