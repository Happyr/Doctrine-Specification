<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;

/**
 * Class LessThan
 *
 * @author Tobias Nyholm
 *
 */
class LessThan extends Comparison
{
    protected function getComparisonExpression()
    {
        return DoctrineComparison::LT;
    }
}