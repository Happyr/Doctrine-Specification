<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;

/**
 * Class LessOrEqualThan
 *
 * @author Tobias Nyholm
 *
 */
class LessOrEqualThan extends Comparison
{
    protected function getComparisonExpression()
    {
        return DoctrineComparison::LTE;
    }
}