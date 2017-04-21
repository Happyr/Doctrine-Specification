<?php

namespace Happyr\DoctrineSpecification\Specification;

use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\QueryModifier\QueryModifier;

interface Specification extends Filter, QueryModifier
{
}
