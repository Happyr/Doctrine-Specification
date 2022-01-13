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

    $field = ArgumentToOperandConverter::toField('image');

    return (string) $qb->expr()->isNull($field->transform($qb, $context));
}
```

You will get a `QueryBuilder` and a `$context` as parameters. The `$context` is (by default) the alias for the root
entity. You may use or change the alias as you like.

### Modify

Implement this function if you want to make any changes to the query object. Say that you want to join an other table
or limit the result set. Consider this `SmartContestCache`.

```php
public function modify(AbstractQuery $query): void
{
    if ($this->contest->isEnded()) {
        $lifetime = 3600;
    } elseif (!$this->contest->voteOptions()->isVotingEnabled()) {
        $lifetime = 600;
    } else {
        $lifetime = 300;
    }

    $query->setResultCacheLifetime($lifetime);
}
```

### FilterCollection

You can write a rule with which you will filter the collection of entities and discard non-matching entities.

```php
public function filterCollection(iterable $collection, ?string $context = null): iterable
{
    $field = ArgumentToOperandConverter::toField($this->field);
    $value = ArgumentToOperandConverter::toValue($this->value);

    foreach ($collection as $candidate) {
        if ($field->execute($candidate, $context) === $value->execute($candidate, $context))) {
            yield $candidate;
        }
    }
}
```

### IsSatisfiedBy

You can check a specific entity against a specific rule.

```php
public function isSatisfiedBy($candidate, ?string $context = null): bool
{
    $field = ArgumentToOperandConverter::toField($this->field);
    $value = ArgumentToOperandConverter::toValue($this->value);

    return $field->execute($candidate, $context) >= $value->execute($candidate, $context);
}
```

## BaseSpecification

To make your life easier you may use the `Happyr\DoctrineSpecification\Specification\BaseSpecification` class. When you
extend  this class you don't need to bother with `getFilter`, `modify`, `filterCollection` or `isSatisfiedBy`. You need
to do 2 things:

1. If you implement a constructor, make sure to call the parent constructor with `$context`
2. Implement `getSpec` to return your `Specifications`

Consider the following example.

```php
use Happyr\DoctrineSpecification\Specification\BaseSpecification;
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

You also don't need to worry about joins. The Happyr Doctrine Specification will do everything for you.

```php
use Happyr\DoctrineSpecification\Specification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

/**
 * Matches every questionnaires of active user in active contests
 */
class PublishedQuestionnaires extends BaseSpecification
{
    /**
     * @return Filter|QueryModifier
     */
    public function getSpec()
    {
        return Spec::andX(
            Spec::eq('state', State::active()->value(), 'contestant.user'),
            Spec::eq('enabled', true, 'contestant.contest')
        );
    }
}
```

The greatest benefit from specs is when you divide rules into small specs and compose them.

```php
final class PublishedQuestionnaires extends BaseSpecification
{
    /**
     * @return Filter|QueryModifier
     */
    protected function getSpec()
    {
        return new ContestantPublished('contestant');
    }
}

final class ContestantPublished extends BaseSpecification
{
    /**
     * @return Filter|QueryModifier
     */
    protected function getSpec()
    {
        return Spec::andX(
            new JoinedContestant(),
            new ContestantApproved()
        );
    }
}

final class JoinedContestant extends BaseSpecification
{
    /**
     * @return Filter|QueryModifier
     */
    protected function getSpec()
    {
        return Spec::andX(
            new UserActivated('user'),
            new ContestPublished('contest')
        );
    }
}

final class UserActivated extends BaseSpecification
{
    /**
     * @return Filter|QueryModifier
     */
    protected function getSpec()
    {
        return Spec::eq('state', State::active()->value());
    }
}

final class ContestPublished extends BaseSpecification
{
    /**
     * @return Filter|QueryModifier
     */
    protected function getSpec()
    {
        return Spec::eq('enabled', true);
    }
}

final class ContestantApproved extends BaseSpecification
{
    /**
     * @return Filter|QueryModifier
     */
    protected function getSpec()
    {
        return Spec::orX(
            Spec::eq('permission', Permission::approved()->value()),
            Spec::not(new ContestRequireModeration('contest'))
        );
    }
}

final class ContestRequireModeration extends BaseSpecification implements Satisfiable
{
    /**
     * @return Filter|QueryModifier
     */
    protected function getSpec()
    {
        return Spec::eq('join_options.require_moderation', true);
    }
}
```
