<?php

namespace Happyr\DoctrineSpecification\Logic;

use Happyr\DoctrineSpecification\Filter\Base\FilterInterface;
use Happyr\DoctrineSpecification\InternalSpecificationInterface;
use Happyr\DoctrineSpecification\SpecificationInterface;

class Not implements LogicX, InternalSpecificationInterface
{
    /**
     * @var FilterInterface
     */
    private $expression;

    /**
     * @param SpecificationInterface $expression
     */
    public function __construct(InternalSpecificationInterface $expression)
    {
        $this->expression = $expression;
    }

    /**
     * @return SpecificationInterface
     */
    public function getExpression()
    {
        return $this->expression;
    }
}
