<?php

namespace Happyr\Doctrine\Specification\Tests;

use Happyr\Doctrine\Specification\Spec;

/**
 * Class SpecTest
 *
 * @author Tobias Nyholm
 */
class SpecTest extends \PHPUnit_Framework_TestCase
{

    public function testStaticCall()
    {
        $spec1=$this->getMockBuilder('Happyr\Doctrine\Specification\Spec\Equals')
            ->disableOriginalConstructor()
            ->getMock();
        $spec2=$this->getMockBuilder('Happyr\Doctrine\Specification\Spec\Equals')
            ->disableOriginalConstructor()
            ->getMock();

        //test logic
        $result=Spec::andX($spec1, $spec2);
        $this->assertInstanceOf('Happyr\Doctrine\Specification\Spec\LogicX', $result);

        //test collection
        $result=Spec::collection($spec1, $spec2);
        $this->assertInstanceOf('Happyr\Doctrine\Specification\Spec\LogicX', $result);

        //test comparison
        $result=Spec::eq('name', 'foobar');
        $this->assertInstanceOf('Happyr\Doctrine\Specification\Spec\Comparison', $result);

        //test other
        $result=Spec::not($spec1);
        $this->assertInstanceOf('Happyr\Doctrine\Specification\Spec\Not', $result);

        $result=Spec::isNotNull($spec1);
        $this->assertInstanceOf('Happyr\Doctrine\Specification\Spec\IsNotNull', $result);
    }

    /**
     * @expectedException \LogicException
     */
    public function testInvalidCall()
    {
        Spec::foobar('test');
    }
}