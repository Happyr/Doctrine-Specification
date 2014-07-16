<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;

/**
 * Class GreatherOrEqualThan
 *
 * @author Tobias Nyholm
 *
 */
class GreatherOrEqualThan extends Comparison
{
    protected function getComparisonExpression()
    {
        return DoctrineComparison::GTE;
    }
}