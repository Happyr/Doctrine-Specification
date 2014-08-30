# Happyr Doctrine Specification

This library gives you a new way for writing queries. Using the [Specification pattern][wiki_spec_pattern] you will
get small Specification classes that are highly reusable.

The problem with writing Doctrine queries is that it soon will be messy. When your application grows you will have
20+ function in your Doctrine repositories. All with long and complicated QueryBuilder calls. You will also find that
you are using a lot of parameters to the same method to accommodate different use cases.

This library was created with a lot of inspiration from Benjamin Eberlei's [blog post][whitewashing] and
from my (Tobias Nyholm) discussion with Kacper Gunia on [Sound of Symfony podcast][sos].

### Table of contents

1. [Motivation](#why-do-we-need-this-lib) and [basic understanding](#the-practical-differences) (this page)
2. [Usage examples][doc-usage]
3. [Create your own spec][doc-create]


## Why do we need this lib?

You are probably wondering why we created this library. Your entity repositories are working just fine as they are, right?
But if your friend open one of your repository classes he will find that the code is not as perfect as you thought.
Entity repositories has a tendency to get messy. Problems may include:

 * Too many functions (`findActiveUser`, `findActiveUserWithPicture`, `findUserToEmail`, etc)
 * Too many arguments
 * Code duplicate
 * Difficult to test

## Requirements of the solution

The solution should have the following features:

* Easy to test
* Easy to extend, store and run
* Re-useable code
* Single responsibility principle
* Hides the implementation details of the ORM. (This might seen like nitpicking, however it leads to bloated client code
doing the query builder work over and over again.)

## The practical differences

This is an example of how you use the lib. Say that you want to fetch some Adverts and close them. We should select all Adverts that have past their `endDate`. If `endDate` is null make it 4 weeks after the `startDate`.

``` php
// Not using the lib
$qb=$this->em->getRepository('HappyrRecruitmentBundle:Advert')
    ->createQueryBuilder('r');

return $qb->where('r.ended = 0')
    ->andWhere(
        $qb->expr()
            ->orX('r.endDate < :now',
                $qb->expr()->andX('r.endDate IS NULL', 'r.startDate < :timeLimit')))
    ->setParameter('now', new \DateTime())
    ->setParameter('timeLimit', new \DateTime('-4weeks'))
    ->getQuery()
    ->getResult();
```

``` php
// Using the lib
$spec = Spec::andX(
    Spec::eq('ended', 0),
    Spec::orX(
        Spec::lt('endDate', new \DateTime()),
        Spec::andX(
            Spec::isNull('endDate'),
            Spec::lt('startDate', new \DateTime('-4weeks'))
        )
    )
);

return $this->em->getRepository('HappyrRecruitmentBundle:Advert')->match($spec);
```

Yes, it looks pretty much the same. But the later is reusable. Say you want another query to fetch Adverts that we
 should close but only for a specific company.
 
#### Doctrine Specification

``` php

class AdvertsWeShouldClose extends BaseSpecification
{
  public function __construct($dqlAlias=null)
  {
    parent::__construct($dqlAlias);
    $this->spec = Spec::andX(
      Spec::eq('ended', 0),
      Spec::orX(
        Spec::lt('endDate', new \DateTime()),
        Spec::andX(
          Spec::isNull('endDate'),
          Spec::lt('startDate', new \DateTime('-4weeks'))
        )
      )
    );
  }

  // the support() function
}

class OwnedByCompany extends BaseSpecification
{
  public function __construct(Company $company, $dqlAlias=null)
  {
    parent::__construct($dqlAlias);
    $this->spec = Spec::collection(
      Spec::join('company', 'c'),
      Spec::eq('id', $company->getId(), 'c')
    );
  }

  // the support() function
}

class SomeService
{
  /**
   * Fetch Adverts that we should close but only for a specific company
   */
  public function myQuery(Company $company)
  {
    $spec = Spec::andX(
      new AdvertsWeShouldClose(),
      new OwnedByCompany($company)
    );

    return $this->em->getRepository('HappyrRecruitmentBundle:Advert')->match($spec);
  }
}
```

#### QueryBuilder

If you were about to do the same thing with only the QueryBuilder it would look like this:

``` php
class AdvertRepository extends EntityRepository
{
  public function myQuery(Company $company)
  {
    $qb=$this->em->getRepository('HappyrRecruitmentBundle:Advert')
      ->createQueryBuilder('r');
    $this->filterAdvertsWeShouldClose($qb)
    $this->filterOwnedByCompany($qb, $company)

    return $qb
      ->getQuery()
      ->getResult();
  }

  protected function filterAdvertsWeShouldClose($qb)
  {
    return $qb
      ->andWhere('r.ended = 0')
      ->andWhere(
          $qb->expr()
              ->orX('r.endDate < :now',
                  $qb->expr()->andX('r.endDate IS NULL', 'r.startDate < :timeLimit')))
      ->setParameter('now', new \DateTime())
      ->setParameter('timeLimit', new \DateTime('-4weeks'));
  }

  protected function filterOwnedByCompany($qb, Company $company)
  {
    return $qb
      ->join('company', 'c')
      ->andWhere('c.id = :company_id')
      ->setParameter('company_id', $company->getId())
  }
}
```

The issues with the QueryBuilder implementation are:

* You may only use the filters `filterOwnedByCompany` and `filterAdvertsWeShouldClose` inside AdvertRepository.
* You can not build a tree with And/Or/Not. Say that you want every Advert but not those owned by $company. There 
is no way to reuse `filterOwnedByCompany()` in that case.
* Different parts of the QueryBuilder filtering cannot be composed together, because of the way the API is created.
Assume we have a filterGroupsForApi() call, there is no way to combine it with another call filterGroupsForPermissions().
Instead reusing this code will lead to a third method filterGroupsForApiAndPermissions().

## Continue reading

You may want to take a look at some [usage examples][doc-usage] or find out
how to [create your own spec][doc-create].



[whitewashing]: http://www.whitewashing.de/2013/03/04/doctrine_repositories.html
[wiki_spec_pattern]: http://en.wikipedia.org/wiki/Specification_pattern
[sos]: http://www.soundofsymfony.com/episode/episode-2/
[doc-usage]: docs/0-usage.md
[doc-create]: docs/1-creatingSpecs.md
