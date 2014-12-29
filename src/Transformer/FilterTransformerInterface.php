<?php

namespace Happyr\DoctrineSpecification\Transformer;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Base\FilterInterface;
use Happyr\DoctrineSpecification\ParametersBag;

interface FilterTransformerInterface
{
    /**
     * Return true when transformer supports class
     *
     * @param FilterInterface $filter
     * @return boolean
     */
    public function supports(FilterInterface $filter);

    /**
     * Transform filter to DQL part
     * @param FilterInterface $filter
     * @param ParametersBag $parameters
     *
     * @return string
     */
    public function transform(FilterInterface $filter, ParametersBag $parameters);

    /**
     * @param QueryBuilder $queryBuilder
     */
    public function setQueryBuilder(QueryBuilder $queryBuilder);
}
