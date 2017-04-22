<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\SpecificationCollection;

class SpecificationCollectionTransformer implements QueryBuilderTransformerCollectionAware
{
    use QueryBuilderTransformerCollectionAwareTrait;

    /**
     * @param Specification $specification
     * @param QueryBuilder  $qb
     * @param string        $dqlAlias
     *
     * @return string|null
     */
    public function transform(Specification $specification, QueryBuilder $qb, $dqlAlias)
    {
        if ($specification instanceof SpecificationCollection &&
            $this->collection instanceof QueryBuilderTransformerCollection
        ) {
            $andX = $qb->expr()->andX();

            foreach ($specification->getSpecifications() as $specification) {
                if ($condition = $this->collection->transform($specification, $qb, $dqlAlias)) {
                    $andX->add($condition);
                }
            }

            return $andX->count() ? (string) $andX : null;
        }

        return null;
    }
}
