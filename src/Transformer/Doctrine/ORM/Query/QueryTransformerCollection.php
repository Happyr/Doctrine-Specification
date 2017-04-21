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
use Happyr\DoctrineSpecification\ResultModifier\ResultModifier;

class QueryTransformerCollection implements QueryTransformer
{
    /**
     * @var QueryTransformer[]
     */
    private $transformers = [];

    /**
     * @param QueryTransformer[] $transformers
     */
    public function __construct(array $transformers = [])
    {
        foreach ($transformers as $transformer) {
            $this->addTransformer($transformer);
        }
    }

    /**
     * @param QueryTransformer $transformer
     */
    public function addTransformer(QueryTransformer $transformer)
    {
        $this->transformers[] = $transformer;
    }

    /**
     * @param ResultModifier $modifier
     * @param AbstractQuery  $query
     *
     * @return AbstractQuery
     */
    public function transform(ResultModifier $modifier, AbstractQuery $query)
    {
        foreach ($this->transformers as $transformer) {
            $query = $transformer->transform($modifier, $query);
        }
    }
}
