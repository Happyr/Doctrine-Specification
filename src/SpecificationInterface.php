<?php

namespace Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Filter\Filter;

interface SpecificationInterface extends InternalSpecificationInterface
{
    /**
     * For custom specification (outside the library) return internal one.
     * E.g. BlackCarSpecification->getSpecification should return Equals('color', 'black') (InternalSpecificationInterface).
     *
     * @return InternalSpecificationInterface
     */
    public function getSpecification();
}
