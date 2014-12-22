<?php

namespace Happyr\DoctrineSpecification\Transformer;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Filter\IsNotNull;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Filter\IsNull;

class DoctrineQueryBuilderTransformer
{
    private $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function getQueryBuilder(Specification $specification)
    {
        $qb = clone $this->queryBuilder;
        $qb->add('where', $this->resolve($qb, $specification->getFilter()));

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param Filter $filter
     *
     * @return string
     */
    private function resolve(QueryBuilder $qb, Filter $filter)
    {
        if ($filter instanceof IsNull) {
            return (string)($qb->expr()->isNull($filter->getField()));
        } elseif ($filter instanceof IsNotNull) {
            return (string)($qb->expr()->isNotNull($filter->getField()));
        }
        throw new InvalidArgumentException(sprintf("Unssuported filter %s", get_class($filter)));
    }
}
