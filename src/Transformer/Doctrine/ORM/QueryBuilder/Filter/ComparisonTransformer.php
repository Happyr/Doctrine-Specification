<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter;

use Doctrine\ORM\Query\Expr\Comparison as DoctrineComparison;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Filter\Comparison;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ValueConverter;

abstract class ComparisonTransformer implements QueryBuilderTransformer
{
    const EQ = DoctrineComparison::EQ;
    const NEQ = DoctrineComparison::NEQ;
    const LT = DoctrineComparison::LT;
    const LTE = DoctrineComparison::LTE;
    const GT = DoctrineComparison::GT;
    const GTE = DoctrineComparison::GTE;

    /**
     * @var array
     */
    private static $operators = [
        self::EQ,
        self::NEQ,
        self::LT,
        self::LTE,
        self::GT,
        self::GTE,
    ];

    /**
     * @param Comparison   $specification
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     * @param string       $operator
     *
     * @return string
     */
    protected function getCondition(Comparison $specification, QueryBuilder $qb, $dqlAlias, $operator)
    {
        if (!in_array($operator, self::$operators)) {
            throw new InvalidArgumentException(sprintf(
                '"%s" is not a valid comparison operator. Valid operators are: "%s"',
                $operator,
                implode(', ', self::$operators)
            ));
        }

        $paramName = $this->getParameterName($qb);
        $value = ValueConverter::convertToDatabaseValue($specification->getValue(), $qb);

        $qb->setParameter($paramName, $value);

        return (string) new DoctrineComparison(
            sprintf('%s.%s', $dqlAlias, $specification->getField()),
            $operator,
            sprintf(':%s', $paramName)
        );
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
