<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Query\QueryStuff;
use Happyr\DoctrineSpecification\Where\Expression;

/**
 * Interface Specification
 *
 * @author Benjamin Eberlei
 */
interface Specification extends Expression, QueryStuff
{

}
