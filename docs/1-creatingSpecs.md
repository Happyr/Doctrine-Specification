# Creating specs

A `Specification` is a class that can filter the result (implements the `Filter` interface) and modify the query
(implements the `QueryModifier` interface). There are two important functions `getFilter` and `modify` respectively.
When you create a specification you should implement `Happyr\DoctrineSpecification\Specification`.

You could choose to only implement `Filter` if you know and are sure that you (or your child
specifications) are using the `QueryModifier::modify`. Same goes the other way around for `QueryModifier`. It is
however recommended to use the `Specification` interface at all times.

### GetFilter

The `getFilter` function is where the action happens. You are most probably to return a `$qb->expr()->xxx()` of some kind. Or you may
choose to return null. Consider this `ImageIsNullFilter`

```php
public function getFilter(QueryBuilder $qb, string $context): string
{
    if ($this->context !== null) {
        $context = $this->context;
    }

    return (string) $qb->expr()->isNull(sprintf('%s.image', $context));
}
```

You will get a QueryBuilder and a $context as parameters. The $context is (by default) the alias for the root entity.
You may use or change the alias as you like.


### Modify

Implement this function if you want to make any changes to the query object. Say that you want to join an other table
or limit the result set. Consider this `JoinUserSettingsModifier`.

```php
/**
 * @param QueryBuilder $qb
 * @param string       $context
 */
public function modify(QueryBuilder $qb, string $context): void
{
    if ($this->context !== null) {
        $context = $this->context;
    }

    $qb->join(sprintf('%s.settings', $context), 'settings');
}

```


## BaseSpecification

To make your life easier you may use the `Happyr\DoctrineSpecification\BaseSpecification` class. When you extend
this class you don't need to bother with `getFilter` or `modify`. You need to do 2 things:

1. If you implement a constructor, make sure to call the parent constructor with $context
2. Implement `getSpec` to return your `Specifications`

Consider the following example.

```php
use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

/**
 * Matches every active user
 */
class IsActive extends BaseSpecification
{
    /**
     * @return Filter|QueryModifier
     */
    public function getSpec()
    {
        return Spec::andX(
            Spec::eq('banned', false),
            Spec::gt('lastLogin', new \DateTime('-6months'))
        );
    }
}
```
