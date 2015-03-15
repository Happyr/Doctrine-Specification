# Integrating with frameworks - Zend 1
## Replacing the default repository type
Doctrine integration with Zend Framework 1 is done manually. However, replacing the default repository type is still
simple. In the bootstrap (or wherever Doctrine is configured in the system in question), use Doctrine configurations
`setRepositoryFactory` method and provide an implementation of `Doctrine\ORM\Repository\RepositoryFactory`. A basic
implementation is provided with `Happyr\DoctrineSpecification\RepositoryFactory`.

```php
// During doctrine configuration
$config->setRepositoryFactory(new \Happyr\DoctrineSpecification\RepositoryFactory());
```
