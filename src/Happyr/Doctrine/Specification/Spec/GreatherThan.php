<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;

/**
 * Class GreatherThan
 *
 * @author Tobias Nyholm
 *
 */
class GreatherThan extends Comparison
{
    protected function getComparisonExpression()
    {
        return DoctrineComparison::GT;
    }
}