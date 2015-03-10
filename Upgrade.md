# Upgrade from 0.2 to dev-master

It has been many changes since 0.2 and we refactored quite a lot. These are the biggest changes.

## Changed interfaces

The old `Specification` interface has been split up to two parts. We got a `Expression` with will modify the `SELECT` clause of
the SQL query. We also got the `Query\Modifier` interface the modifies the query.

The new `Specification` interface extends `Query\Modifier` and `Expression`.

You have to update your specifications to comply with `Query\Modifier` and/or `Expression`


## BaseSpecification

There are two new abstract methods `getWrappedModifier` and `getExpression`.

## EntitySpecificationRepository

The `match` method has changed to take a second optional parameter of a `Result\Modifier`. You may modify the result by chnaging
the hydration mode or to add a cache. We decided that it would not be a part of a `Specification`.