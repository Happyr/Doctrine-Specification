<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Query\ResultModifier;

use Doctrine\ORM\AbstractQuery;
use Happyr\DoctrineSpecification\ResultModifier\AsSingleScalar;
use Happyr\DoctrineSpecification\ResultModifier\ResultModifier;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Query\QueryTransformer;

class AsSingleScalarTransformer implements QueryTransformer
{
    /**
     * @param ResultModifier $modifier
     * @param AbstractQuery  $query
     *
     * @return AbstractQuery
     */
    public function transform(ResultModifier $modifier, AbstractQuery $query)
    {
        if ($modifier instanceof AsSingleScalar) {
            $query->setHydrationMode(AbstractQuery::HYDRATE_SINGLE_SCALAR);
        }

        return $query;
    }
}
