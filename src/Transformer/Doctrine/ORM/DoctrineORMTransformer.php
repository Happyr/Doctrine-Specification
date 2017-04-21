<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\ResultModifier\ResultModifier;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Query\QueryTransformerCollection;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformerCollection;

class DoctrineORMTransformer
{
    /**
     * @var QueryTransformerCollection
     */
    private $q_transformer;

    /**
     * @var QueryBuilderTransformerCollection
     */
    private $qb_transformer;

    /**
     * @param QueryTransformerCollection $q_transformer
     * @param QueryBuilderTransformerCollection $qb_transformer
     */
    public function __construct(QueryTransformerCollection $q_transformer, QueryBuilderTransformerCollection $qb_transformer)
    {
        $this->q_transformer = $q_transformer;
        $this->qb_transformer = $qb_transformer;
    }

    /**
     * @param Specification $specification
     * @param ResultModifier|null $modifier
     * @param QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return AbstractQuery
     */
    public function transform(Specification $specification, ResultModifier $modifier = null, QueryBuilder $qb, $dqlAlias)
    {
        $qb = $this->qb_transformer->transform($specification, $qb, $dqlAlias);

        $query = $qb->getQuery();

        if ($modifier !== null) {
            $query = $this->q_transformer->transform($modifier, $query);
        }

        return $query;
    }
}
