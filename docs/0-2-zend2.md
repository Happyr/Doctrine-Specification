# Integrating with frameworks - Zend 2
## Replacing the default repository type
Doctrine integration with Zend Framework 2 can be achieved using the `DoctrineORM` bundle. This bundle contains
configuration options for the repository factory. To replace the default repository type, provide a factory creating
 an instance of `Happyr\DoctrineSpecification\EntitySpecificationRepository` and any necessary configuration options.

```php
// Application configuration
'doctrine' => array(
    'configuration' => array(
        'orm_default' => array(
            'repository_factory' => 'happyr_doctrinespecification_repository',
        )
    ),

    'service_manager' => array(
        'services' => array(
            'happyr_doctrinespecification_repository' => new Happyr\DoctrineSpecification\RepositoryFactory()
        )
    )
);
```
    