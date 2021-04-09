# Integrating with frameworks - Zend Framework 1

## Replacing the default repository type

Doctrine integration with Zend Framework 1 is done manually. However, replacing the default repository type is still
simple. In the bootstrap (or wherever Doctrine is configured in the system in question), use Doctrine configurations
`setDefaultRepositoryClassName` method and provide an implementation of `Doctrine\Common\Persistence\ObjectRepository`.
A basic implementation is provided with `Happyr\DoctrineSpecification\Repository\EntitySpecificationRepository`.

```php
// During Doctrine configuration
$config->setDefaultRepositoryClassName(\Happyr\DoctrineSpecification\Repository\EntitySpecificationRepository::class);
```
