<?php

namespace Transformer;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\DoctrineTransformer;
use Happyr\DoctrineSpecification\Filter\Base\FilterInterface;
use Happyr\DoctrineSpecification\Logic\Not;
use Happyr\DoctrineSpecification\ParametersBag;
use Happyr\DoctrineSpecification\Transformer\FilterTransformerInterface;

class LogicTransformer implements FilterTransformerInterface
{
    /**
     * @var Expr
     */
    private $expression;

    /**
     * @var DoctrineTransformer
     */
    private $rootTransformer;

    /**
     * @inheritdoc
     */
    public function setExpression(Expr $expression)
    {
        $this->expression = $expression;
    }

    public function __construct(DoctrineTransformer $rootTransformer)
    {
        $this->rootTransformer = $rootTransformer;
    }

    public function supports(FilterInterface $filter)
    {
        return $filter instanceof Not;
    }

    /**
     * Transform filter to DQL part
     * @param FilterInterface $filter
     * @param ParametersBag $parameters
     *
     * @return string
     */
    public function transform(FilterInterface $filter, ParametersBag $parameters)
    {
        if ($filter instanceof Not) {
            return $this->transformNot($filter);
        }
    }


    private function transformNot(Not $filter)
    {
        return $this->expression->not($this->rootTransformer->transform($filter->getExpression()));
    }
}
