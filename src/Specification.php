<?php

namespace Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Filter\Expression;
use Happyr\DoctrineSpecification\Query\QueryModifier;

interface Specification extends Expression, QueryModifier
{

}
