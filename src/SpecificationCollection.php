<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification;

class SpecificationCollection implements Specification
{
    /**
     * @var Specification[]
     */
    private $specifications;

    /**
     * Construct it with two or more instances of Specification.
     *
     * @param Specification $specification1
     * @param Specification $specification2
     */
    public function __construct(Specification $specification1, Specification $specification2)
    {
        foreach (func_get_args() as $specification) {
            $this->addSpecification($specification);
        }
    }

    /**
     * @param Specification $specification
     */
    public function addSpecification(Specification $specification)
    {
        $this->specifications[] = $specification;
    }

    /**
     * @return Specification[]
     */
    public function getSpecifications()
    {
        return $this->specifications;
    }
}
