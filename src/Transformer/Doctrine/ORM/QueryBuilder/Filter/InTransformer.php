<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\In;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ValueConverter;

class InTransformer implements QueryBuilderTransformer
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
        if ($specification instanceof In) {
            $paramName = $this->getParameterName($qb);
            $value = $specification->getValue();

            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $value[$k] = ValueConverter::convertToDatabaseValue($v, $qb);
                }
            } else {
                $value = ValueConverter::convertToDatabaseValue($value, $qb);
            }

            $qb->setParameter($paramName, $value);
            $qb->andWhere((string) $qb->expr()->in(
                sprintf('%s.%s', $dqlAlias, $specification->getField()),
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
        return sprintf('in_%d', $qb->getParameters()->count());
    }
}
