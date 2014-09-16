<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Specification;

/**
 * Class OrderBy
 *
 * @author Tobias Nyholm
 */
class OrderBy implements QueryStuff
{
    /**
     * @var string field
     */
    protected $field;

    /**
     * @var string order
     */
    protected $order;

    /**
     * @var string dqlAlias
     */
    protected $dqlAlias;

    /**
     * @param string $field
     * @param string $order
     * @param string|null $dqlAlias
     */
    public function __construct($field, $order='ASC', $dqlAlias = null)
    {
        $this->field = $field;
        $this->order = $order;
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string $dqlAlias
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        $qb->orderBy(sprintf('%s.%s', $dqlAlias, $this->field), $this->order);
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
