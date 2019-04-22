# Installation and usage

Install this lib with composer.

```js
// composer.json
{
    // ...
    require: {
        // ...
        "happyr/doctrine-specification": "dev-master@dev",
    }
}
```

Let your repositories extend `Happyr\DoctrineSpecification\EntitySpecificationRepository` instead of `Doctrine\ORM\EntityRepository`.
Also make sure that the default repository is changed. If you haven't created a repository class in your source
then you will have to tell `$this->em->getRepository('xxx')` to return a instance of `Happyr\DoctrineSpecification\EntitySpecificationRepository`.
See instructions for [Laravel](0-3-laravel.md), [Symfony2](0-0-symfony.md), [Zend1](0-1-zend1.md) and [Zend2](0-2-zend2.md).

Then you may start to create your specifications. Put them in `Acme\DemoBundle\Entity\Spec`. Lets start with a simple one:

```php
<?php

namespace Acme\DemoBundle\Entity\Spec;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

/**
 * Check if a user is active.
 * An active user is not banned and has logged in within the last 6 months.
 */
class IsActive extends BaseSpecification
{
    public function getSpec()
    {
        return Spec::andX(
            Spec::eq('banned', false),
            Spec::gt('lastLogin', new \DateTime('-6months'))
        );
    }
}
```

I recommend you to write simple Specifications and combine them with `Spec::andX` and `Spec::orX`. To use the `IsActive`
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
        $users = $this->getEntityManager()
            ->getRepository('AcmeDemoBundle:User')
            ->match(new IsActive())
        ;

        // Do whatever with your active users
    }
}
```

## Syntactic sugar

There is a few different ways of using a `Specification`. You might use the `Spec` factory which probably is the most
convenient one. (At least it reduces the number of imports.)

```php
use Happyr\DoctrineSpecification\Spec;

// ...

$objects= $this->getEntityManager()
    ->getRepository('...')
    ->match(Spec::gt('age', 18));
```

You may of course use the specification classes directly.

```php
use Happyr\DoctrineSpecification\Comparison\GreaterThan;

// ...

$objects= $this->getEntityManager()
    ->getRepository('...')
    ->match(new GreaterThan('age', 18))
;
```

Some specifications inherits from the `Comparison` specification (ie `Equals`, `GreaterThan`, `LessOrEqualThan`). You may choose to
interact with directly with the `Comparison` class.

```php

use Happyr\DoctrineSpecification\Comparison\Comparison;

// ...

$objects= $this->getEntityManager()
    ->getRepository('...')
    ->match(new Comparison(Comparison::GT, 'age', 18))
;
```


### Re-cap

* ```Spec::gt('age', 18)```
* ```new GreaterThan('age', 18)```
* ```new Comparison(Comparison::GT, 'age', 18)```



# ResultModifier

When you call `EntitySpecificationRepository::match` with your specification as first parameter you may use a `ResultModifier`
as second parameter to modify the result.  An excellent use-case of this function is
when you want to change the Hydration mode.

```php
public function anyFunction()
{
    $repo = // EntitySpecificationRepository
    $spec = new MySpecification();

    $entitiesAsArray = $repo->match($spec, new AsArray());

    // Do whatever
}

```

You can use multiple `ResultModifiers` with the `ResultModifierCollection`.
```php
public function anyFunction()
{
    $repo = // EntitySpecificationRepository
    $spec = new MySpecification();
    $resultModifiers = new ResultModifierCollection(
        new AsArray(),
        new Cache(60),
    );

    $entities = $repo->match($spec, $resultModifiers);

    // Do whatever
}

```

# Comparison operands

All a comparison operations in the filters consist of the left operand, operator and the right operand. As default the
left operand can be a entity field, and the right operand a value. This is a simple and effective mechanic to solve the
standard tasks.
But operands can be not only scalar values. You can use objects that implement the
`Happyr\DoctrineSpecification\Operand\Operand` interface. For example, you can compare two fields:

```php
// DQL: e.price_current < e.price_old
$spec = Spec::lt(Spec::field('price_current'), Spec::field('price_old'));
```

You can compare fields of different entities:

```php
// DQL: a.email = u.email
$spec = Spec::eq(Spec::field('email', 'a'), Spec::field('email', 'u));
```

You can also customize data type values:

```php
// DQL: e.day > :day
$spec = Spec::gt('day', Spec::value($day, Type::DATE));
```

```php
// DQL: e.day IN (:days)
$spec = Spec::in('day', Spec::values($days, Type::DATE));
```

# Customize selection

Sometimes we need to customize the selection. To do this, we can use `select` and `addSelect` query modifiers. Example
of selection single field:

```php
// DQL: SELECT e.email FROM ...
Spec::select('email')
// or
Spec::select(Spec::field('email'))
```

Add single field in the selected set:

```php
// DQL: SELECT e, u.email FROM ...
Spec::addSelect(Spec::field('email', $dqlAlias))
```

Add one more custom fields in the selected set:

```php
// DQL: SELECT e.title, e.cover, u.name, u.avatar FROM ...
Spec::andX(
    Spec::select('title', 'cover'),
    Spec::addSelect(Spec::field('name', $dqlAlias), Spec::field('avatar', $dqlAlias))
)
```

Add single entry in the selected set:

```php
// DQL: SELECT e, u FROM ...
Spec::addSelect(Spec::selectEntity($dqlAlias))
```

Use aliases for selection fields:

```php
// DQL: SELECT e.name AS author FROM ...
Spec::select(Spec::selectAs(Spec::field('name'), 'author'))
```

Add single hidden field in the selected set:

```php
// DQL: SELECT e, u.name AS HIDDEN author FROM ...
Spec::addSelect(Spec::selectHiddenAs(Spec::field('email', $dqlAlias), 'author')))
```

Use expression in selection for add product discount to the result:

```php
// DQL: SELECT (e.price_old is not null and e.price_current < e.price_old) AS discount FROM ...
Spec::select(Spec::selectAs(
    Spec::andX(
        Spec::isNotNull('price_old'),
        Spec::lt(Spec::field('price_current'), Spec::field('price_old'))
    ),
    'discount'
))
```

Use aliases in conditions to search a cheap products:

```php
// DQL: SELECT e.price_current AS price FROM ... WHERE price < :low_cost_limit
Spec::andX(
    Spec::select(Spec::selectAs('price_current', 'price')),
    Spec::lt(Spec::alias('price'), $low_cost_limit)
)
```
