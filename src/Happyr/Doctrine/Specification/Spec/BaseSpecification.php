<?php


namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

/**
 * Class BaseSpecification
 *
 * Extend this abstract class if you want to build a new spec with your domain logic
 *
 * @author Tobias Nyholm
 */
abstract class BaseSpecification implements Specification
{
    /**
     * @var Specification spec
     *
     */
    protected $spec;

    /**
     * @var string|null dqlAlias
     *
     */
    protected $dqlAlias;

    /**
     * @param string $dqlAlias
     */
    public function __construct($dqlAlias = null)
    {
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return Expr|null
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->spec === null) {
            return;
        }

        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        return $this->spec->match($qb, $dqlAlias);
    }

    /**
     * @param AbstractQuery|null $query
     */
    public function modifyQuery(AbstractQuery $query)
    {
        if ($this->spec === null) {
            return;
        }

        $this->spec->modifyQuery($query);
    }
}