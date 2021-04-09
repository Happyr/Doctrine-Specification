# Integrating with frameworks - Laravel

## Replacing the default repository type

Replacing Doctrine's default repository type with `Happyr\DoctrineSpecification\Repository\EntitySpecificationRepository`
is easy in Laravel. The Doctrine bundle provides a place in configuration to specify the new type.

```php
// doctrine.php
use Happyr\DoctrineSpecification\Repository\EntitySpecificationRepository;

return [
    'managers' => [
        'default' => [
            'repository' => EntitySpecificationRepository::class,
        ],
    ],
];
```
