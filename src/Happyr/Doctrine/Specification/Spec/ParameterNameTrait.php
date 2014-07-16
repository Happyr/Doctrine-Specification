<?php


namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\QueryBuilder;

/**
 * Class ParameterNameTrait
 *
 * @author Tobias Nyholm
 *
 */
trait ParameterNameTrait 
{
    /**
     * Get a good unique parameter name
     *
     * @param QueryBuilder $qb
     *
     * @return string
     */
    protected function getParameterName(QueryBuilder $qb)
    {
        return sprintf('happyr_%d', $qb->getParameters()->count());
    }
} 