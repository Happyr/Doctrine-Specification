<?php

namespace spec\Happyr\DoctrineSpecification\Spec;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Like;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LikeSpec extends ObjectBehavior
{
    private $field = "foo";

    private $value = "bar";

    public function let()
    {
        $this->beConstructedWith($this->field, $this->value, Like::CONTAINS);
    }

    public function it_is_a_specification()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Specification');
    }
}
