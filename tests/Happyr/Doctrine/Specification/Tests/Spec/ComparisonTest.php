<?php

namespace Happyr\Doctrine\Specification\Tests\Spec;

use Happyr\Doctrine\Specification\Spec\Equals;

/**
 * @author Tobias Nyholm
 */
class ComparisonTest extends BaseSpecTest
{

    public function testComparison()
    {
        $qb=$this->getQueryBuilderMock(array('setParameter'));
        $qb->expects($this->once())
            ->method('setParameter')
            ->with($this->anything(), $this->equalTo('bar'));

        $spec = $this->getMockBuilder('Happyr\Doctrine\Specification\Spec\Comparison')
            ->setMethods(array('getParameterName', 'getComparisonExpression'))
            ->setConstructorArgs(array('foo', 'bar'))
            ->getMockForAbstractClass();

        $spec->expects($this->once())
            ->method('getParameterName')
            ->with($this->identicalTo($qb))
            ->will($this->returnValue('placeholder'));

        $spec->expects($this->once())
            ->method('getComparisonExpression')
            ->will($this->returnValue('op'));


        $result=$this->runSpec($spec, $qb, null, 'm');

        $this->assertInstanceOf('Doctrine\ORM\Query\Expr\Comparison', $result);
        $this->assertEquals('m.foo', $result->getLeftExpr(), 'Left expression does not match the expected');
        $this->assertEquals('op', $result->getOperator(), 'The operator was unexpected');
        $this->assertEquals(':placeholder', $result->getRightExpr(), 'Issues with the placeholder');
    }
} 