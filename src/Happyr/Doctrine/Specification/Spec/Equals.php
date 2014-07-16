<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;

/**
 * Class Equals
 *
 * @author Tobias Nyholm
 *
 */
class Equals extends Comparison
{
    protected function getComparisonExpression()
    {
        return DoctrineComparison::EQ;
    }
}