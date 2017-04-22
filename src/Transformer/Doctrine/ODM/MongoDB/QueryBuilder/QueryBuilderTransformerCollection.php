<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ODM\MongoDB\QueryBuilder;

use Doctrine\ODM\MongoDB\Query\Builder;
use Happyr\DoctrineSpecification\Specification;

class QueryBuilderTransformerCollection implements QueryBuilderTransformer
{
    /**
     * @var QueryBuilderTransformer[]
     */
    private $transformers = [];

    /**
     * @param QueryBuilderTransformer[] $transformers
     */
    public function __construct(array $transformers = [])
    {
        foreach ($transformers as $transformer) {
            $this->addTransformer($transformer);
        }
    }

    /**
     * @param QueryBuilderTransformer $transformer
     */
    public function addTransformer(QueryBuilderTransformer $transformer)
    {
        $this->transformers[] = $transformer;

        if ($transformer instanceof QueryBuilderTransformerCollectionAware) {
            $transformer->setCollection($this);
        }
    }

    /**
     * @param Specification $specification
     * @param Builder       $qb
     */
    public function transform(Specification $specification, Builder $qb)
    {
        foreach ($this->transformers as $transformer) {
            $transformer->transform($specification, $qb);
        }
    }
}
