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
use Happyr\DoctrineSpecification\ResultModifier\ResultModifierCollection;
use Happyr\DoctrineSpecification\ResultModifier\ResultModifier;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Query\QueryTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Query\QueryTransformerCollection;

class ResultModifierCollectionTransformer implements QueryTransformer
{
    /**
     * @var QueryTransformerCollection
     */
    private $collection;

    /**
     * @param QueryTransformerCollection $collection
     */
    public function __construct(QueryTransformerCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @param ResultModifier $modifier
     * @param AbstractQuery  $query
     */
    public function transform(ResultModifier $modifier, AbstractQuery $query)
    {
        if ($modifier instanceof ResultModifierCollection) {
            foreach ($modifier->getModifiers() as $child) {
                $this->collection->transform($child, $query);
            }
        }
    }
}
