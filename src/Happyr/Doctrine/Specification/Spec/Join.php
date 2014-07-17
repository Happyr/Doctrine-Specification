<?php

namespace Happyr\Doctrine\Specification\Spec;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class Join
 *
 * @author Tobias Nyholm
 *
 *
 */
class Join implements Specification
{
    /**
     * @var string field
     *
     */
    private $field;

    /**
     * @var string alias
     *
     */
    private $newAlias;
    private $dqlAlias;

    /**
     * @param string $field
     * @param string $newAlias
     * @param string $dqlAlias
     */
    public function __construct($field, $newAlias, $dqlAlias = null)
    {
        $this->field = $field;
        $this->newAlias = $newAlias;
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param string $dqlAlias
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }
        $qb->join($dqlAlias . '.' . $this->field, $this->newAlias);
    }

    /**
     * @param \Doctrine\ORM\AbstractQuery $query
     */
    public function modifyQuery(AbstractQuery $query)
    {
    }

    /**
     * @param string $className
     *
     * @return bool
     */
    public function supports($className)
    {
        return true;
    }
}