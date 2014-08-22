# Creating specs

Every spec should implement `Happyr\Doctrine\Specification\Spec\Specification`. The interface has 3 functions.

### Match

The match function is where the action happens. You are most probably to return a `$qb->expr()` of some kind. Or you may
choose to return null and just do...

``` php

public function match(QueryBuilder $qb, $dqlAlias)
{
    $qb->join(...);

    // or

    $qb->setMaxResults(2);
}
```

You will get a QueryBuilder and a $dqlAlias as parameters. The $dqlAlias is (by default) the alias for the root entity.
 You may use or change the alias as you like.


### ModifyQuery

Implement this function if you want to make any changes to the query object. An excellent use-case of this funciton is
when you want to change the Hydration mode.

```php

<?php

namespace Acme\DemoBundle\Entity\Spec;

use Doctrine\ORM\AbstractQuery;

/**
 * Get the result as an array
 */
class AsArray extends S\BaseSpecification
{
   public function modifyQuery(AbstractQuery $query)
   {
       $query->setHydrationMode(AbstractQuery::HYDRATE_ARRAY);
   }
}

```

### Supports

The purpose of this function is to return a boolean if this spec supports the current class. You will get the
fully qualified name of the entity as a parameter.

## BaseSpecification

If you are creating your own Specification you are most likely to use other specifications. To make your life
easier you may use the `Happyr\Doctrine\Specification\Spec\BaseSpecification` class. When you inherit
from this class you don't need to bother with `match` or `modifyQuery`. You need to do 3 things:

1. Call the parent constructor
2. Add your Specifications to $this->spec
3. Implement the `support` function


Consider the following example.

``` php
/**
 * Matches every active user
 */
class IsActive extends S\BaseSpecification
{
    /**
     * @param string $dqlAlias
     */
    public function __construct($dqlAlias=null)
    {
        // you need to call the parent constructor
        parent::__construct($dqlAlias);

        // you need to make sure $this->spec is assigned with an object that inherits Specification
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
``

