<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
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
     */
    public function transform(ResultModifier $modifier, AbstractQuery $query)
    {
        foreach ($this->transformers as $transformer) {
            $transformer->transform($modifier, $query);
        }
    }
}
