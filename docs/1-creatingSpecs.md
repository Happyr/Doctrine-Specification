# Creating specs

Every spec should implement `Happyr\Doctrine\Specification\Spec\Specification`. The interface has 3 functions.

## Match

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


## ModifyQuery

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

## Supports

The purpose of this function is to return a boolean if this spec supports the current class. You will get the
fully qualified name of the entity as a parameter.