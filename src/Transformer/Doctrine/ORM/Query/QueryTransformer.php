<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Query;

use Doctrine\ORM\AbstractQuery;
use Happyr\DoctrineSpecification\Result\ResultModifier;

interface QueryTransformer
{
    /**
     * @param ResultModifier $modifier
     * @param AbstractQuery $query
     *
     * @return AbstractQuery
     */
    public function transform(ResultModifier $modifier, AbstractQuery $query);
}
