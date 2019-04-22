# Upgrade from 0.7 to 0.8

The `CountOf` specification not expect a `Specification` as argument.
The `ResultModifier` in `EntitySpecificationRepositoryInterface` method arguments now is nullable.
Added new method `EntitySpecificationRepositoryInterface::getQueryBuilder()` and
`EntitySpecificationRepositoryTrait::getQueryBuilder()` for get Doctrine QueryBuilder with specification.

# Upgrade from 0.6 to 0.7

Removed `AsSingle` result modifier. Consider using `AsSingleScalar`.

# Upgrade from 0.5 to 0.6

No BC breaks

# Upgrade from 0.4 to 0.5

Moved `Happyr\DoctrineSpecification\Specification` to `Happyr\DoctrineSpecification\Specification\Specification`.

# Upgrade from 0.3 to 0.4

## BaseSpecification

Merged `getFilterInstance` and `getQueryModifierInstance` into `getSpec`. The new function should return a `Filter`
and/or a `QueryBuilder`. We did this to make the API easier.

## LogicX

You can now do `Spec::andx(new MyFilter(), new MyQueryModifier);` with both `Filter`s and `QueryBuilder`s.

# Upgrade from 0.2 to 0.3

It has been many changes since 0.2 and we refactored quite a lot. These are the biggest changes.

## Changed interfaces

The old `Specification` interface has been split up to two parts. We got a `Filter` with will modify the `SELECT`
clause of the SQL query. We also got the `QueryModifier` interface the modifies the query (Limit, Order, Join etc). 

The new `Specification` interface extends `Filter` and `QueryModifier`.

You have to update your specifications to comply with `QueryModifier` and/or `Expression`


## BaseSpecification

There are two new methods `getFilter` and `modify`. You don't need to override these. You may use BaseSpecfication as
normal. 

The `supports` function has been removed.

## EntitySpecificationRepository

The `match` method has changed to take a second optional parameter of a `ResultModifier`. You may modify the result by
changing the hydration mode or to add a cache. We decided that it would not be a part of a `Specification`.
