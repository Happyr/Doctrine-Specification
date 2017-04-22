<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ODM\MongoDB\QueryBuilder\Filter;

use Doctrine\ODM\MongoDB\Query\Builder;
use Happyr\DoctrineSpecification\Filter\LessOrEqualThan;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ODM\MongoDB\QueryBuilder\QueryBuilderTransformer;

class LessOrEqualThanTransformer implements QueryBuilderTransformer
{
    /**
     * @param Specification $specification
     * @param Builder       $qb
     */
    public function transform(Specification $specification, Builder $qb)
    {
        if ($specification instanceof LessOrEqualThan) {
            $qb->field($specification->getField())->lte($specification->getValue());
        }
    }
}
