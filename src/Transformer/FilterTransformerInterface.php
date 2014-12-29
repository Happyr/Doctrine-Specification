<?php

namespace Happyr\DoctrineSpecification\Transformer;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Base\FilterInterface;
use Happyr\DoctrineSpecification\ParametersBag;

interface FilterTransformerInterface
{
    public function supports(FilterInterface $filter);

    public function transform(FilterInterface $filter, ParametersBag $parameters);

    public function setQueryBuilder(QueryBuilder $queryBuilder);
}
