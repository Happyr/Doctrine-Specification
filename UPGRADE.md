# Upgrade from 1.1 to 2.0

* The `AbstractJoin::getJoinType()` method was removed. Use `AbstractJoin::modifyJoin()` method inside.
* The `Comparison` class marked as `abstract`.
* The `LogicX` class marked as `abstract`.
* The `protected` properties in `Comparison` class marked as `private`.
* The `protected` properties in `In` class marked as `private`.
* The `protected` properties in `GroupBy` class marked as `private`.
* The `protected` properties in `OrderBy` class marked as `private`.
* The `protected` properties in `Limit` class marked as `private`.
* The `protected` properties in `Offset` class marked as `private`.
* The `Bitwise` operands was removed.
* The `Happyr\DoctrineSpecification\Specification\Having` class was removed, use
  `Happyr\DoctrineSpecification\Query\Having` instead.
* The `Happyr\DoctrineSpecification\EntitySpecificationRepository` class was removed, use
  `Happyr\DoctrineSpecification\Repository\EntitySpecificationRepository` instead.
* The `Happyr\DoctrineSpecification\EntitySpecificationRepositoryInterface` class was removed, use
  `Happyr\DoctrineSpecification\Repository\EntitySpecificationRepositoryInterface` instead.
* The `Happyr\DoctrineSpecification\EntitySpecificationRepositoryTrait` class was removed, use
  `Happyr\DoctrineSpecification\Repository\EntitySpecificationRepositoryTrait` instead.
* The `Happyr\DoctrineSpecification\RepositoryFactory` class was removed, use
  `Happyr\DoctrineSpecification\Repository\RepositoryFactory` instead.
* The `Happyr\DoctrineSpecification\BaseSpecification` class was removed, use
  `Happyr\DoctrineSpecification\Specification\BaseSpecification` instead.
* Removes the ability to use `array` as argument for the `PlatformFunction` operand.

  Before:

  ```php
  $arguments = ['create_at', new \DateTimeImmutable()];
  Spec::DATE_DIFF($arguments);
  Spec::fun('DATE_DIFF', $arguments);
  new PlatformFunction('DATE_DIFF', $arguments);
  ```

  After:

  ```php
  $arguments = ['create_at', new \DateTimeImmutable()];
  Spec::DATE_DIFF(...$arguments);
  Spec::fun('DATE_DIFF', ...$arguments);
  new PlatformFunction('DATE_DIFF', ...$arguments);
  ```

* Removes the ability to use `array` as argument for the `Select` query modifier.

  Before:

  ```php
  $fields = ['title', 'cover'];
  Spec::select($fields);
  new Select($fields);
  ```

  After:

  ```php
  $fields = ['title', 'cover'];
  Spec::select(...$fields);
  new Select(...$fields);
  ```

* Removes the ability to use `array` as argument for the `AddSelect` query modifier.

  Before:

  ```php
  $fields = ['title', 'cover'];
  Spec::addSelect($fields);
  new AddSelect($fields);
  ```

  After:

  ```php
  $fields = ['title', 'cover'];
  Spec::addSelect(...$fields);
  new AddSelect(...$fields);
  ```

* The `BaseSpecification::getSpec()` method marked as `abstract`.
* The `InvalidArgumentException` class marked as `final`.
* The `LogicException` class marked as `final`.
* The `NonUniqueResultException` class marked as `final`.
* The `NoResultException` class marked as `final`.
* The `UnexpectedResultException` class marked as `abstract`.
* All the filter classes marked as `final`.
* All the logic classes marked as `final`.
* All the operand classes marked as `final`.
* All the query modifier classes marked as `final`.
* All the result modifier classes marked as `final`.
* The `CountOf` class marked as `final`.
* The `DBALTypesResolver` class marked as `final`.
* The `ValueConverter` class marked as `final`.
* The `EntitySpecificationRepositoryTrait::getAlias()` method returns nothing else.
* The `Operand::execute()` method was added. This method performs the necessary actions on the operand and returns the
  result. It is desirable to return a scalar value so that it is compatible with other operands.
* The custom platform functions also need to be made executable and register the executor in the registry.

  ```php
  PlatformFunction::getExecutorRegistry()->register('POW', fn ($base, $exp) => pow($base, $exp));
  ```
* The use of DQL aliases has been replaced with descriptions of contexts.

  Before:

  ```php
  Spec::andX(
      Spec::innerJoin('contestant', 'ct'),
      Spec::innerJoin('contest', 'c', 'ct'),
      Spec::innerJoin('user', 'u', 'ct'),
      Spec::eq('state', State::active()->value(), 'u'),
      Spec::eq('enabled', true, 'c')
  );
  ```

  After:

  ```php
  Spec::andX(
      Spec::eq('state', State::active()->value(), 'contestant.user'),
      Spec::eq('enabled', true, 'contestant.contest')
  );
  ```

* Changed behavior of DQL aliases to use context.

  Before:

  ```php
  final class PublishedQuestionnaires extends BaseSpecification
  {
      private string $contest_alias;

      private string $contestant_alias;

      private string $user_alias;

      public function __construct(
          string $contest_alias = 'c',
          string $contestant_alias = 'ct',
          string $user_alias = 'u',
          ?string $dql_alias = null
      ) {
          $this->contest_alias = $contest_alias;
          $this->contestant_alias = $contestant_alias;
          $this->user_alias = $user_alias;
          parent::__construct($dql_alias);
      }

      /**
       * @return Filter|QueryModifier
       */
      protected function getSpec()
      {
          return Spec::andX(
              Spec::innerJoin('contestant', $this->contestant_alias),
              new ContestantPublished($this->contest_alias, $this->user_alias, $this->contestant_alias)
          );
      }
  }

  final class ContestantPublished extends BaseSpecification
  {
      private string $contest_alias;

      private string $user_alias;

      public function __construct(string $contest_alias = 'c', string $user_alias = 'u', ?string $dql_alias = null)
      {
          $this->contest_alias = $contest_alias;
          $this->user_alias = $user_alias;
          parent::__construct($dql_alias);
      }

      /**
       * @return Filter|QueryModifier
       */
      protected function getSpec()
      {
          return Spec::andX(
              new JoinedContestant($this->contest_alias, $this->user_alias),
              new ContestantApproved($this->contest_alias)
          );
      }
  }

  final class ContestantApproved extends BaseSpecification implements Satisfiable
  {
      private string $contest_alias;

      public function __construct(string $contest_alias = 'c', ?string $dql_alias = null)
      {
          $this->contest_alias = $contest_alias;
          parent::__construct($dql_alias);
      }

      /**
       * @return Filter|QueryModifier
       */
      protected function getSpec()
      {
          return Spec::orX(
              Spec::eq('permission', Permission::approved()->value()),
              Spec::not(new ContestRequireModeration($this->contest_alias))
         );
      }
  }
  ```

  After:

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

  final class ContestantApproved extends BaseSpecification implements Satisfiable
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
  ```

* The `Satisfiable` interface was added.
* The `Specification` interface was extends `Satisfiable` interface.
* The `BaseSpecification` class implement `Satisfiable` interface.
* The `Happyr\DoctrineSpecification\Operand\CountDistinct` class was removed, use
  `Happyr\DoctrineSpecification\Operand\PlatformFunction\Count` instead.
* The `Spec::countDistinct()` method was removed, use `Spec::COUNT()` instead.

  Before:

  ```php
  new CountDistinct('field_name');
  Spec::countDistinct('field_name');
  ```

  After:

  ```php
  new Count('field_name', true);
  Spec::COUNT('field_name', true);
  ```

* The `COUNT` function as argument to `Spec::fun()` is not longer supported, use `Spec::COUNT()` instead.
* The `COUNT` function as argument to `Happyr\DoctrineSpecification\Operand\PlatformFunction` is not longer supported,
  use `Happyr\DoctrineSpecification\Operand\PlatformFunction\Count` instead.

  Before:

  ```php
  new PlatformFunction('COUNT', 'field_name');
  Spec::fun('COUNT', 'field_name');
  ```

  After:

  ```php
  new Count('field_name');
  Spec::COUNT('field_name');
  ```

* The `AVG` function as argument to `Spec::fun()` is not longer supported, use `Spec::AVG()` instead.
* The `AVG` function as argument to `Happyr\DoctrineSpecification\Operand\PlatformFunction` is not longer supported,
  use `Happyr\DoctrineSpecification\Operand\PlatformFunction\Avg` instead.

  Before:

  ```php
  new PlatformFunction('AVG', 'field_name');
  Spec::fun('AVG', 'field_name');
  ```

  After:

  ```php
  new Avg('field_name');
  Spec::AVG('field_name');
  ```

* The `MIN` function as argument to `Spec::fun()` is not longer supported, use `Spec::MIN()` instead.
* The `MIN` function as argument to `Happyr\DoctrineSpecification\Operand\PlatformFunction` is not longer supported,
  use `Happyr\DoctrineSpecification\Operand\PlatformFunction\Min` instead.

  Before:

  ```php
  new PlatformFunction('MIN', 'field_name');
  Spec::fun('MIN', 'field_name');
  ```

  After:

  ```php
  new Min('field_name');
  Spec::MIN('field_name');
  ```

* The `MAX` function as argument to `Spec::fun()` is not longer supported, use `Spec::MAX()` instead.
* The `MAX` function as argument to `Happyr\DoctrineSpecification\Operand\PlatformFunction` is not longer supported,
  use `Happyr\DoctrineSpecification\Operand\PlatformFunction\Max` instead.

  Before:

  ```php
  new PlatformFunction('MAX', 'field_name');
  Spec::fun('MAX', 'field_name');
  ```

  After:

  ```php
  new Max('field_name');
  Spec::MAX('field_name');
  ```

* The `SUM` function as argument to `Spec::fun()` is not longer supported, use `Spec::SUM()` instead.
* The `SUM` function as argument to `Happyr\DoctrineSpecification\Operand\PlatformFunction` is not longer supported,
  use `Happyr\DoctrineSpecification\Operand\PlatformFunction\Sum` instead.

  Before:

  ```php
  new PlatformFunction('SUM', 'field_name');
  Spec::fun('SUM', 'field_name');
  ```

  After:

  ```php
  new Sum('field_name');
  Spec::SUM('field_name');
  ```

* Define `Spec::leftJoin()`, `Spec::innerJoin()` and `Spec::join()` before using the new alias from it.

  Before:

  ```php
  $spec = Spec::andX(
      Spec::select(Spec::selectEntity('person')),
      Spec::leftJoin('person', 'person')
  );
  ```

  After:

  ```php
  $spec = Spec::andX(
      Spec::leftJoin('person', 'person'),
      Spec::select(Spec::selectEntity('person'))
  );
  ```

# Upgrade from 1.0 to 1.1

* No BC breaks

# Upgrade from 0.8 to 1.0

* The `Comparison` no longer supports the operator `LIKE`. Use the `Like` filter.
* The `Like` filter no longer expands the `Comparison` base filter.
* The `IsNotNull` filter no longer expands the `IsNull` base filter.

# Upgrade from 0.7 to 0.8

* The `CountOf` specification not expect a `Specification` as argument.
* The `ResultModifier` in `EntitySpecificationRepositoryInterface` method arguments now is nullable.
* Added new method `EntitySpecificationRepositoryInterface::getQueryBuilder()` and
  `EntitySpecificationRepositoryTrait::getQueryBuilder()` for get Doctrine QueryBuilder with specification.

# Upgrade from 0.6 to 0.7

* Removed `AsSingle` result modifier. Consider using `AsSingleScalar`.

# Upgrade from 0.5 to 0.6

* No BC breaks

# Upgrade from 0.4 to 0.5

* Moved `Happyr\DoctrineSpecification\Specification` to `Happyr\DoctrineSpecification\Specification\Specification`.

# Upgrade from 0.3 to 0.4

## BaseSpecification

* Merged `getFilterInstance` and `getQueryModifierInstance` into `getSpec`. The new function should return a `Filter`
  and/or a `QueryBuilder`. We did this to make the API easier.

## LogicX

* You can now do `Spec::andx(new MyFilter(), new MyQueryModifier);` with both `Filter`s and `QueryBuilder`s.

# Upgrade from 0.2 to 0.3

* It has been many changes since 0.2 and we refactored quite a lot. These are the biggest changes.

## Changed interfaces

* The old `Specification` interface has been split up to two parts. We got a `Filter` with will modify the `SELECT`
  clause of the SQL query. We also got the `QueryModifier` interface the modifies the query (Limit, Order, Join etc).
* The new `Specification` interface extends `Filter` and `QueryModifier`.
* You have to update your specifications to comply with `QueryModifier` and/or `Expression`


## BaseSpecification

* There are two new methods `getFilter` and `modify`. You don't need to override these. You may use BaseSpecfication as
  normal.
* The `supports` function has been removed.

## EntitySpecificationRepository

* The `match` method has changed to take a second optional parameter of a `ResultModifier`. You may modify the result
  by changing the hydration mode or to add a cache. We decided that it would not be a part of a `Specification`.
