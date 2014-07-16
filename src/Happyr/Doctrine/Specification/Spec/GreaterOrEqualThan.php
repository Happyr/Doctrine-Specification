<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;

/**
 * Class GreaterOrEqualThan
 *
 * @author Tobias Nyholm
 *
 */
class GreaterOrEqualThan extends Comparison
{
    protected function getComparisonExpression()
    {
        return DoctrineComparison::GTE;
    }
}