# Integrating with frameworks - Symfony

## Replacing the default repository type

Replacing Doctrine's default repository type with `Happyr\DoctrineSpecification\Repository\EntitySpecificationRepository` is easy
in Symfony. The Doctrine bundle provides a place in configuration to specify the new type.

```yml
# app/config/config.yml
doctrine:
    orm:
        default_repository_class: 'Happyr\DoctrineSpecification\Repository\EntitySpecificationRepository'
```
