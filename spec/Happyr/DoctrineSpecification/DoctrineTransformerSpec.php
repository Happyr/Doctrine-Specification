<?php

namespace spec\Happyr\DoctrineSpecification;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Base\FilterInterface;
use Happyr\DoctrineSpecification\ParametersBag;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\DoctrineTransformer;
use Happyr\DoctrineSpecification\Transformer\FilterTransformerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin DoctrineTransformer
 */
class DoctrineTransformerSpec extends ObjectBehavior
{
    function let(ParametersBag $parameters)
    {
        $this->beConstructedWith($parameters);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\DoctrineTransformer');
    }

    function it_transforms_specifications_to_query(
        QueryBuilder $qb,
        Specification $specification,
        FilterTransformerInterface $transformer,
        FilterInterface $filter,
        ParametersBag $parameters
    )
    {
        $specification->getFilter()->willReturn($filter);
        $transformer->supports($filter)->willReturn(true);
        $transformer->transform($filter, $parameters, Argument::type('Doctrine\ORM\QueryBuilder'))->willReturn('DQL');
        $parameters->clear()->shouldBeCalled();
        $parameters->has()->willReturn(true);
        $parameters->get()->willReturn([1 => 'value']);

        $qb->add('where', 'DQL')->shouldBeCalled();
        $qb->setParameters([1 => 'value'])->shouldBeCalled();

        $this->setQueryBuilder($qb);
        $this->addTransformer($transformer);

        $this->transform($specification)->shouldReturn($qb);
    }
}
