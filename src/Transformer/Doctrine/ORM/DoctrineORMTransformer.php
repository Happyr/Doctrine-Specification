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
    private $qTransformer;

    /**
     * @var QueryBuilderTransformerCollection
     */
    private $qbTransformer;

    /**
     * @param QueryTransformerCollection        $qTransformer
     * @param QueryBuilderTransformerCollection $qbTransformer
     */
    public function __construct(
        QueryTransformerCollection $qTransformer,
        QueryBuilderTransformerCollection $qbTransformer
    ) {
        $this->qTransformer = $qTransformer;
        $this->qbTransformer = $qbTransformer;
    }

    /**
     * @param Specification       $specification
     * @param ResultModifier|null $modifier
     * @param QueryBuilder        $qb
     * @param string              $dqlAlias
     *
     * @return AbstractQuery
     */
    public function transform(
        Specification $specification,
        ResultModifier $modifier = null,
        QueryBuilder $qb,
        $dqlAlias
    ) {
        $qb = $this->qbTransformer->transform($specification, $qb, $dqlAlias);

        $query = $qb->getQuery();

        if ($modifier !== null) {
            $query = $this->qTransformer->transform($modifier, $query);
        }

        return $query;
    }
}