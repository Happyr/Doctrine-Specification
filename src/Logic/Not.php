<?php

namespace Happyr\DoctrineSpecification\Logic;

use Happyr\DoctrineSpecification\Filter\Base\FilterInterface;
use Happyr\DoctrineSpecification\SpecificationInterface;

class Not implements LogicX
{
    /**
     * @var FilterInterface
     */
    private $expression;

    /**
     * @param FilterInterface $expression
     */
    public function __construct(FilterInterface $expression)
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

    /**
     * @return mixed Return field name to filter
     */
    public function getField()
    {
    }
}
