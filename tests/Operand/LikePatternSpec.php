<?php

namespace tests\Happyr\DoctrineSpecification\Operand;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\LikePattern;
use PhpSpec\ObjectBehavior;

/**
 * @mixin LikePattern
 */
class LikePatternSpec extends ObjectBehavior
{
    private $value = 'foo';

    private $format = LikePattern::CONTAINS;

    public function let()
    {
        $this->beConstructedWith($this->value, $this->format);
    }

    public function it_is_a_value()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Operand\LikePattern');
    }

    public function it_is_a_operand()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Operand\Operand');
    }

    public function it_is_transformable(QueryBuilder $qb, ArrayCollection $parameters)
    {
        $dqlAlias = 'a';

        $qb->getParameters()->willReturn($parameters);
        $parameters->count()->willReturn(10);

        $qb->setParameter('comparison_10', sprintf($this->format, $this->value))->shouldBeCalled();

        $this->transform($qb, $dqlAlias)->shouldReturn(':comparison_10');
    }
}
