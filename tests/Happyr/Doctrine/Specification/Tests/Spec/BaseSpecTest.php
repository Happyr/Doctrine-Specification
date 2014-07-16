<?php

namespace Happyr\Doctrine\Specification\Tests\Spec;

use Doctrine\ORM\AbstractQuery;
use Happyr\Doctrine\Specification\Spec\Specification;

/**
 * Class BaseTest
 *
 * @author Tobias Nyholm
 *
 */
class BaseSpecTest extends \PHPUnit_Framework_TestCase
{
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
     * Run the specification
     *
     * @param Specification $spec
     * @param AbstractQuery $query
     *
     */
    protected function runSpec(Specification $spec, AbstractQuery $query)
    {
        $spec->modifyQuery($query);
    }
} 