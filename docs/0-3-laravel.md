# Integrating with frameworks - Laravel
## Replacing the default repository type
If you're choosing to use Doctrine with Laravel, there are some common Doctrine integration packages, however only some of them allow configruation of the default repository type.

### atrauzzi/laravel-doctrine
For this package, set the `defaultRepository` setting to `Happyr\Doctrine\Specification\EntitySpecificationRepository`

###  mitchellvanw/laravel-doctrine
For this package, set the `repository` setting to `Happyr\Doctrine\Specification\EntitySpecificationRepository`

