<?php

namespace Happyr\Doctrine\Specification\Tests;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

/**
 * Class EntitySpecificationRepositoryTest
 *
 * @author Tobias Nyholm
 *
 */
class EntitySpecificationRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Happyr\Doctrine\Specification\EntitySpecificationRepository repo
     *
     */
    protected $repo;

    public function setUp()
    {
        $query = $this->getMockBuilder('\Doctrine\ORM\AbstractQuery')
            ->setMethods(array('setParameter', 'getResult'))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $query->expects($this->any())
            ->method('getResult')
            ->will($this->returnValue('result'));

        $qb = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock();
        $qb->expects($this->any())
            ->method('where')
            ->with(
                $this->callback(
                    function ($expr) {
                        return $expr instanceof Expr\Base || $expr instanceof Expr\Comparison;
                    }
                )
            )
            ->will($this->returnSelf());

        $qb->expects($this->any())
            ->method('getQuery')
            ->will($this->returnValue($query));

        $repo = $this->getMockBuilder('Happyr\Doctrine\Specification\EntitySpecificationRepository')
            ->setMethods(array('getEntityName', 'createQueryBuilder'))
            ->disableOriginalConstructor()
            ->getMock();
        $repo->expects($this->once())
            ->method('getEntityName')
            ->will($this->returnValue('foobar'));

        $repo->expects($this->any())
            ->method('createQueryBuilder')
            ->with($this->equalTo('e'))
            ->will($this->returnValue($qb));

        $this->repo = $repo;
    }

    public function testMatch()
    {

        $spec = $this->getSpecificationMock();

        $spec->expects($this->once())
            ->method('supports')
            ->with($this->equalTo('foobar'))
            ->will($this->returnValue(true));

        $spec->expects($this->once())
            ->method('match')
            ->with(
                $this->callback(
                    function ($spec) {
                        return $spec instanceof QueryBuilder;
                    }
                ),
                $this->equalTo('e'))
            ->will($this->returnValue(new \Doctrine\ORM\Query\Expr\Comparison('1', '=', '1')));

        $spec->expects($this->once())
            ->method('modifyQuery');

        $this->repo->match($spec);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMatchNotSupported()
    {
        $spec = $this->getSpecificationMock();
        $spec->expects($this->once())
            ->method('supports')
            ->with($this->equalTo('foobar'))
            ->will($this->returnValue(false));

        $this->repo->match($spec);
    }

    /**
     *
     *
     *
     * @return mixed
     */
    private function getSpecificationMock()
    {
        $spec = $this->getMockBuilder('Happyr\Doctrine\Specification\Spec\Specification')
            ->setMethods(array('supports', 'match', 'modifyQuery'))
            ->getMock();

        return $spec;
    }
}