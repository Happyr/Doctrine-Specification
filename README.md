# Happyr Doctrine Specification

This library gives you a new way for writing queries. Using the [Specification pattern][wiki_spec_pattern] you will
get small Specification classes that are highly reusable.

The problem with writing Doctrine queries is that it soon will be messy. When your application grows you will have
20+ function in your Doctrine repositories. All with long and complicated QueryBuilder calls. You will also find that
you are using a lot of parameters to the same method to accommodate different use cases.

This library was created with a lot of inspiration from Benjamin Eberlei's [blog post][whitewashing] and
from my (Tobias Nyholm) discussion with Kacper Gunia on [Sound of Symfony podcast][sos].


single responsibility principle

## The problems

The problems are:

 * Doctrine repository functions get messy
 * Lots of code duplicate
 * It is very hard to test

### Example of bad repos
` Lots of functions `

` Lots of messy code `

`Lots of function arguments`



## The solution

* Re-useable code
* Easy to test
* Easy to extend, store and run
* Hides the implementation details of the ORM. This might seen like nitpicking, however it leads to bloated client code
doing the query builder work over and over again.

### Example using the library

We should close recruitments that has past their `endDate`. If `endDate` is null make it 4 weeks after the `startDate`.

``` php
// Not using the lib

$qb=$this->em->getRepository('HappyrRecruitmentBundle:Recruitment')
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
$spec=new AndX(
    new Equal('ended', 0),
    new OrX(
        new LessThan('endDate', new \DateTime()),
        new AndX(
            new IsNull('endDate'),
            new LessThan('startDate', new \DateTime('-4weeks'))
        )
    )
);

return $this->em->getRepository('HappyrRecruitmentBundle:Recruitment')->match($spec);
```

Yes, it looks pretty much the same. But the later is reusable. Say you want an other query to fetch recruitments that we
 should close but only for a specific company.

``` php

class RecruitmentsWeShouldClose extends ParentSpecification
{
  public function __construct($dqlAlias=null)
  {
    parent::__construct($dqlAlias);
    $this->spec=new AndX(
      new Equals('ended', 0),
      new OrX(
        new LessThan('endDate', new \DateTime()),
        new AndX(
          new IsNull('endDate'),
          new LessThan('startDate', new \DateTime('-4weeks'))
        )
      )
    );
  }

  // the support() function
}

class OwnedByCompany extends ParentSpecification
{
  public function __construct(Company $company, $dqlAlias=null)
  {
    parent::__construct($dqlAlias);
    $this->spec=new Collection(
      new Join('company', 'c'),
      new Equals('id', $company->getId(), 'c')
    );
  }

  // the support() function
}

class SomeService
{
  /**
   * Fetch recruitments that we should close but only for a specific company
   */
  public function myQuery(Company $company)
  {
    $spec = new AndX(
      new RecruitmentsWeShouldClose(),
      new OwnedByCompany($company)
    );

    return $this->em->getRepository('HappyrRecruitmentBundle:Recruitment')->match($spec);
  }
}
```

If you were about to do the same thing with only the QueryBuilder it would look like this:

``` php
class RecruitmentRepository extends EntityRepository
{
  public function myQuery(Company $company)
  {
    $qb=$this->em->getRepository('HappyrRecruitmentBundle:Recruitment')
      ->createQueryBuilder('r');
    $this->filterRecruitmentsWeShouldClose($qb)
    $this->filterOwnedByCompany($qb, $company)

    return $qb
      ->getQuery()
      ->getResult();
  }

  protected function filterRecruitmentsWeShouldClose($qb)
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
      ->join('company', 'c)
      ->andWhere('c.id = :company_id')
      ->setParameter('company_id', $company->getId())
  }
}
```

The issues with the later implementation are:

* You may only use the filterOwnedByCompany inside RecruitmentRepository.
* You can not build a tree with And/Or/Not. Say that you want every recruitment but $company. There is not way to
reuse filterOwnedByCompany() in that case.
* Different parts of the QueryBuilder filtering cannot be composed together, because of the way the API is created.
Assume we have the filterGroupsForApi() call, there is no way to combine it with another call filterGroupsForPermissions().
Instead reusing this code will lead to a third method filterGroupsForApiAndPermissions().


# Usage

Install this lib with composer.

```js
// composer.json
{
    // ...
    require: {
        // ...
        "happyr/doctrine-specification": "dev-master",
    }
}
```

Let your repositories extend Happyr\Doctrine\Specification\EntitySpecificationRepository instead of EntityRepository. Then
you may start to create your specifications. Put them in Acme\DemoBundle\Entity\Spec. Lets start with a simple one:

```php

<?php

namespace Acme\DemoBundle\Entity\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use Happyr\Doctrine\Specification\Spec as S;

/**
 * Check if a user is active.
 * A active user is not banned and has logged in within the last 6 months.
 *
 * @author Tobias Nyholm
 */
class IsActive extends S\ParentSpecification
{
    /**
     * @param string $dqlAlias
     */
    public function __construct($dqlAlias=null)
    {
        parent::__construct($dqlAlias);
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

```

I recommend you to write simple Specifications and combine them with `Spec\AndX` and `Spec\OrX`. To use the `IsActive`
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
    $users=$this->getEntityManager()
      ->getRepository('AcmeDemoBundle:User')
      ->match(new IsActive());

    //Do whatever with your active users

  }
}
```


[whitewashing]: http://www.whitewashing.de/2013/03/04/doctrine_repositories.html
[wiki_spec_pattern]: http://en.wikipedia.org/wiki/Specification_pattern
[sos]: http://www.soundofsymfony.com/episode/episode-2/