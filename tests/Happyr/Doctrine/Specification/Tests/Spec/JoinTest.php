<?php

namespace Happyr\Doctrine\Specification\Tests\Spec;

use Happyr\Doctrine\Specification\Spec\Join;

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
        $qb=$this->getQueryBuilderMock(array('join'));
        $qb->expects($this->once())
            ->method('join')
            ->with($this->equalTo('m.foo'), $this->equalTo('bar'));

        $spec = new Join('foo', 'bar');

        $this->runSpec($spec, $qb, null, 'm');
    }
} 