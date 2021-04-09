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

Let your repositories extend `Happyr\DoctrineSpecification\Repository\EntitySpecificationRepository` instead of `Doctrine\ORM\EntityRepository`, or use the `EntitySpecificationRepositoryTrait` in your repositories, like so:

```php
<?php
declare(strict_types=1);

namespace Acme\DemoBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Happyr\DoctrineSpecification\EntitySpecificationRepositoryTrait;

class MyRepository extends ServiceEntityRepository
{
    // Add this line:
    use EntitySpecificationRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    // ...
}
```

Also make sure that the default repository is changed. If you haven't created a repository class in your source
then you will have to tell `$this->em->getRepository('xxx')` to return a instance of `Happyr\DoctrineSpecification\Repository\EntitySpecificationRepository`.
See instructions for [Laravel](0-3-laravel.md), [Symfony](0-0-symfony.md), [Zend 1](0-1-zend1.md), [Zend 2](0-2-zend2.md), [Zend 3](0-2-zend2.md).

Then you may start to create your specifications. Put them in `Acme\DemoBundle\Entity\Spec`. Lets start with a simple one:

```php
<?php
declare(strict_types=1);

namespace Acme\DemoBundle\Entity\Spec;

use Happyr\DoctrineSpecification\Specification\BaseSpecification;
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
declare(strict_types=1);

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Acme\DemoBundle\Entity\Spec\IsActive;

class DefaultController extends AbstractController
{
    public function someAction(): Response
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

$objects = $this->getEntityManager()
    ->getRepository('...')
    ->match(Spec::gt('age', 18));
```

You may of course use the specification classes directly.

```php
use Happyr\DoctrineSpecification\Comparison\GreaterThan;

// ...

$objects = $this->getEntityManager()
    ->getRepository('...')
    ->match(new GreaterThan('age', 18))
;
```

### Re-cap

* ```Spec::gt('age', 18)```
* ```new GreaterThan('age', 18)```

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
        new Cache(60)
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
$spec = Spec::eq(Spec::field('email', 'a'), Spec::field('email', 'u'));
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

# Arithmetic operands

You can use arithmetic operations in specifications such as `-`, `+`, `*`, `/`, `%`.
For example, select users with a score greater than  `$user_score`:

```php
// DQL: e.posts_count + e.likes_count > :user_score
$spec = Spec::gt(
    Spec::add(Spec::field('posts_count'), Spec::field('likes_count')),
    $user_score
);
```

You can put arithmetic operations in each other:

```php
// DQL: ((e.price_old - e.price_current) / (e.price_current / 100)) > :discount
$spec = Spec::gt(
    Spec::div(
        Spec::sub(Spec::field('price_old'), Spec::field('price_current')),
        Spec::div(Spec::field('price_current'), Spec::value(100))
    ),
    Spec::value($discount)
);
```

# Functions

```php
// DQL: SIZE(e.products) > 2
Spec::gt(Spec::SIZE('products'), 2);
// or
Spec::gt(Spec::fun('SIZE', 'products'), 2);
// or
Spec::gt(Spec::fun('SIZE', Spec::field('products')), 2);
```

Nested functions:

```php
// DQL: TRIM(LOWER(e.email)) = :email
Spec::eq(Spec::TRIM(Spec::LOWER('email')), trim(strtolower($email)));
// or
Spec::eq(
    Spec::fun('TRIM', Spec::fun('LOWER', Spec::field('email'))),
    trim(strtolower($email))
);
```

Without arguments:

```php
Spec::CURRENT_DATE();
Spec::fun('CURRENT_DATE');
```

With one argument:

```php
Spec::LENGTH('email');
Spec::fun('LENGTH', 'email');
```

With several arguments:

```php
Spec::DATE_DIFF('create_at', $date);
Spec::fun('DATE_DIFF', 'create_at', $date);
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
Spec::addSelect(Spec::field('email', $context))
```

Add one more custom fields in the selected set:

```php
// DQL: SELECT e.title, e.cover, u.name, u.avatar FROM ...
Spec::andX(
    Spec::select('title', 'cover'),
    Spec::addSelect(Spec::field('name', $context), Spec::field('avatar', $context))
)
```

Add single entry in the selected set:

```php
// DQL: SELECT e, u FROM ...
Spec::addSelect(Spec::selectEntity($context))
```

Use aliases for selection fields:

```php
// DQL: SELECT e.name AS author FROM ...
Spec::select(Spec::selectAs(Spec::field('name'), 'author'))
```

Add single hidden field in the selected set:

```php
// DQL: SELECT e, u.name AS HIDDEN author FROM ...
Spec::addSelect(Spec::selectHiddenAs(Spec::field('email', $context), 'author')))
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
