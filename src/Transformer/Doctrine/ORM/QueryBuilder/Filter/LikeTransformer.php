<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter;

use Doctrine\ORM\Query\Expr\Comparison;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Like;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ValueConverter;

class LikeTransformer implements QueryBuilderTransformer
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
        if ($specification instanceof Like) {
            $paramName = $this->getParameterName($qb);
            $value = ValueConverter::convertToDatabaseValue($specification->getValue(), $qb);

            if ($specification->getFormat() | Like::ENDS_WITH) {
                $value = '%'.$value;
            }
            if ($specification->getFormat() | Like::STARTS_WITH) {
                $value = $value.'%';
            }

            $qb->setParameter($paramName, $value);
            $qb->andWhere((string) new Comparison(
                sprintf('%s.%s', $dqlAlias, $specification->getField()),
                'LIKE',
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
        return sprintf('like_%d', $qb->getParameters()->count());
    }
}