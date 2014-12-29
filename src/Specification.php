<?php

namespace Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;

interface Specification
{
    public function __construct(Filter $filter);
    public function getFilter();
}
