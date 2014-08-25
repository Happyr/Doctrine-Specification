# Installation and usage

Install this lib with composer.

```js
// composer.json
{
    // ...
    require: {
        // ...
        "happyr/doctrine-specification": "dev-master",
    }
}
```

Let your repositories extend `Happyr\Doctrine\Specification\EntitySpecificationRepository` instead of `Doctrine\ORM\EntityRepository`.
Also make sure that the default repository is changed. If you haven't created a repository class in your source
then `$this->em->getRepository('xxx')` will return an instance of the default repository class.

```js
// app/config/config.yml
doctrine:
  orm:
    default_repository_class: Happyr\Doctrine\Specification\EntitySpecificationRepository

```

Then you may start to create your specifications. Put them in `Acme\DemoBundle\Entity\Spec`. Lets start with a simple one:

```php

<?php

namespace Acme\DemoBundle\Entity\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use Happyr\Doctrine\Specification\Spec as S;

/**
 * Check if a user is active.
 * A active user is not banned and has logged in within the last 6 months.
 *
 * @author Tobias Nyholm
 */
class IsActive extends S\BaseSpecification
{
    /**
     * @param string $dqlAlias
     */
    public function __construct($dqlAlias=null)
    {
        parent::__construct($dqlAlias);
        $this->spec = new S\AndX(
          new S\Equals('banned', false),
          new S\GreaterThan('lastLogin', new \DateTime('-6months'),
        );
    }

    /**
     * @param string $className
     *
     * @return bool
     */
    public function supports($className)
    {
        return $className === 'Acme\DemoBundle\Entity\User';
    }
}

```

I recommend you to write simple Specifications and combine them with `Spec\AndX` and `Spec\OrX`. To use the `IsActive`
Specification, do like this:

```php
<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\DemoBundle\Entity\Spec\IsActive;

class DefaultController extends Controller
{
  public function someAction()
  {
    $users=$this->getEntityManager()
      ->getRepository('AcmeDemoBundle:User')
      ->match(new IsActive());

    //Do whatever with your active users

  }
}
```

## Syntactic sugar

There is a few different ways of using a Spec. You might use the Spec factory which probably is the most
convenient one. (At least it reduces the imports)

``` php

use Happyr\Doctrine\Specification\Spec;

// ...

$objects= $this->getEntityManager()
    ->getRepository('...')
    ->match(Spec::gt('age', 18));

```

You may of course use the Spec classes directly.

``` php

use Happyr\Doctrine\Specification\Spec\GreaterThan;

// ...

$objects= $this->getEntityManager()
    ->getRepository('...')
    ->match(new GreaterThan('age', 18));

```

Some specs inherits from the Comparison spec (ie `Equals`, `GreaterThan`, `LessOrEqualThan`). You may choose to
interact with directly with the Comparison class.

``` php

use Happyr\Doctrine\Specification\Spec\Comparison;

// ...

$objects= $this->getEntityManager()
    ->getRepository('...')
    ->match(new Comparison(Comparison::GT, 'age', 18));

```


### Re-cap

* ```Spec::gt('age', 18)```
* ```new GreaterThan('age', 18)```
* ```new Comparison(Comparison::GT, 'age', 18)```
