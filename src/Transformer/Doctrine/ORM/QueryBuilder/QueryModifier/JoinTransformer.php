<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryModifier;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\QueryModifier\Join;
use Happyr\DoctrineSpecification\Specification;

class JoinTransformer extends AbstractJoinTransformer
{
    /**
     * @param Specification $specification
     * @param QueryBuilder  $qb
     * @param string        $dqlAlias
     *
     * @return string|null
     */
    public function transform(Specification $specification, QueryBuilder $qb, $dqlAlias)
    {
        if ($specification instanceof Join) {
            if ($condition = $this->getCondition($specification, $qb)) {
                $qb->join(
                    sprintf('%s.%s', $dqlAlias, $specification->getField()),
                    $specification->getAlias(),
                    $this->getConditionType($specification),
                    $condition
                );
            } else {
                $qb->join(sprintf('%s.%s', $dqlAlias, $specification->getField()), $specification->getAlias());
            }
        }

        return null;
    }
}
