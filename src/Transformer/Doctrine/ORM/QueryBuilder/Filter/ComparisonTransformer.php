<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter;

use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Comparison;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ValueConverter;

class ComparisonTransformer implements QueryBuilderTransformer
{
    /**
     * @param Specification $specification
     * @param QueryBuilder  $qb
     * @param string        $dqlAlias
     *
     * @return QueryBuilder
     */
    public function transform(Specification $specification, QueryBuilder $qb, $dqlAlias)
    {
        if ($specification instanceof Comparison) {
            $paramName = $this->getParameterName($qb);

            $qb->setParameter($paramName, ValueConverter::convertToDatabaseValue($specification->getValue(), $qb));
            $qb->andWhere((string) new DoctrineComparison(
                sprintf('%s.%s', $dqlAlias, $specification->getField()),
                $specification->getOperator(),
                sprintf(':%s', $paramName)
            ));
        }

        return $qb;
    }

    /**
     * Get a good unique parameter name.
     *
     * @param QueryBuilder $qb
     *
     * @return string
     */
    private function getParameterName(QueryBuilder $qb)
    {
        return sprintf('comparison_%d', $qb->getParameters()->count());
    }
}
