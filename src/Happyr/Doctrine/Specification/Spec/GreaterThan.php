<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;

/**
 * Class GreaterThan
 *
 * @author Tobias Nyholm
 *
 */
class GreaterThan extends Comparison
{
    protected function getComparisonExpression()
    {
        return DoctrineComparison::GT;
    }
}