<?php

namespace Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Result\AsSingleScalar;
use Happyr\DoctrineSpecification\Result\ResultModifier;
use Happyr\DoctrineSpecification\Result\ResultModifierCollection;
use Happyr\DoctrineSpecification\Specification\Specification;

/**
 * This trait should be used by a class extending \Doctrine\ORM\EntityRepository.
 */
trait EntitySpecificationRepositoryCounterTrait
{
    /**
     * Get the number of results match with a Specification.
     *
     * @param Specification  $specification
     * @param ResultModifier $modifier
     *
     * @return int
     */
    public function countOf(Specification $specification, ResultModifier $modifier = null)
    {
        if ($modifier instanceof ResultModifier) {
            $modifier = new ResultModifierCollection($modifier, new AsSingleScalar());
        } else {
            $modifier = new AsSingleScalar();
        }

        return (int) $this->match(Spec::countOf($specification), $modifier);
    }

    /**
     * Have matches with a Specification.
     *
     * @param Specification  $specification
     * @param ResultModifier $modifier
     *
     * @return bool
     */
    public function isSatisfiedBy(Specification $specification, ResultModifier $modifier = null)
    {
        return (bool) $this->countOf($specification, $modifier);
    }
}
