<?php

namespace Happyr\Doctrine\Specification\Tests\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use Happyr\Doctrine\Specification\Spec\Specification;

/**
 * Class BaseTest
 *
 * @author Tobias Nyholm
 *
 */
abstract class BaseSpecTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Run the specification test
     *
     * @param Specification $spec
     * @param AbstractQuery $query
     *
     */
    protected function runSpec(Specification $spec, QueryBuilder $qb=null, AbstractQuery $query=null, $alias='e')
    {
        if ($qb !== null) {
            $spec->match($qb, $alias);
        }

        if ($query !== null) {
            $spec->modifyQuery($query);
        }
    }

    /**
     *
     * Get a mock for the Query
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getQueryMock(array $methods=array())
    {
        return $this->getMockBuilder('\Doctrine\ORM\AbstractQuery')
            ->setMethods($methods)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
    }

    /**
     * Get a mock for the Query Builder
     *
     * @param array $methods
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getQueryBuilderMock(array $methods=array())
    {
        return $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->setMethods($methods)
            ->disableOriginalConstructor()
            ->getMock();
    }
}