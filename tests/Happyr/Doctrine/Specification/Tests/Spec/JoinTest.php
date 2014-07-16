<?php

namespace Happyr\Doctrine\Specification\Tests\Spec;

/**
 * Class JoinTest
 *
 * @author Tobias Nyholm
 *
 */
class JoinTest extends BaseSpecTest
{

    public function testJoin()
    {
        $query=$this->getQueryMock(array('join'));
        $query->expects($this->once())
            ->method('join')
            ->with($this->equalTo('foo'), $this->equalTo('bar'));

        $spec = new Join('foo', 'bar');

        $this->runSpec($spec, $query);
    }
} 