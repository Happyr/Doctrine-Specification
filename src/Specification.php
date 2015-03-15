<?php

namespace Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;

interface Specification extends Filter, QueryModifier
{
}
