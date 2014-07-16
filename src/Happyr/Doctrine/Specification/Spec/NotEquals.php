<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;

/**
 * Class NotEqual
 *
 * @author Tobias Nyholm
 *
 */
class NotEquals extends Comparison
{
    protected function getComparisonExpression()
    {
        return DoctrineComparison::NEQ;
    }
}