# Integrating with frameworks - Symfony 2
## Replacing the default repository type

Replacing Doctrine's default repository type with `Happyr\DoctrineSpecification\EntitySpecificationRepository` is easy
in Symfony 2. The doctrine bundle provides a place in configuration to specify the new type.

```yml
// app/config/config.yml
doctrine:
    orm:
        default_repository_class: Happyr\DoctrineSpecification\EntitySpecificationRepository
```
