# Integrating with frameworks - Zend Framework 2 and 3

## Replacing the default repository type

Doctrine integration with Zend Framework 2 can be achieved using the `DoctrineORM` bundle. This bundle contains
configuration options for the repository. To replace the default repository type, provide a class name of
`Happyr\DoctrineSpecification\Repository\EntitySpecificationRepository`.

```php
// Application configuration
use Happyr\DoctrineSpecification\Repository\EntitySpecificationRepository;

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'default_repository_class' => EntitySpecificationRepository::class,
            ],
        ],
    ],
];
```
