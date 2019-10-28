<?php

namespace tests\Happyr\DoctrineSpecification\Result;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Parameter;
use Happyr\DoctrineSpecification\Result\RoundDateTime;
use PhpSpec\ObjectBehavior;

/**
 * @mixin RoundDateTime
 */
class RoundDateTimeSpec extends ObjectBehavior
{
    private $roundSeconds = 3600;

    public function let()
    {
        $this->beConstructedWith($this->roundSeconds);
    }

    public function it_is_a_specification()
    {
        $this->shouldBeAnInstanceOf(RoundDateTime::class);
    }

    public function it_round_date_time_in_query_parameters_for_given_time(
        AbstractQuery $query,
        Parameter $scalarParam,
        Parameter $datetimeParam
    ) {
        $name = 'now';
        $type = 'datetime';
        $date = new \DateTime('15:55:34');

        $scalarParam->getValue()->willReturn('foo');

        $datetimeParam->getValue()->willReturn($date);
        $datetimeParam->getName()->willReturn($name);
        $datetimeParam->getType()->willReturn($type);

        $query->getParameters()->willReturn(new ArrayCollection([$scalarParam, $datetimeParam]));
        $query->setParameter($name, new \DateTime('15:00:00'), $type)->shouldBeCalled();

        $this->modify($query);
    }
}
