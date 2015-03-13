<?php
namespace Happyr\DoctrineSpecification\Query;
use Doctrine\ORM\QueryBuilder;
class Offset implements QueryModifier
{
    /**
     * @var int limit
     */
    protected $offset;
    /**
     * @param int $limit
     */
    public function __construct($offset)
    {
        $this->offset = $offset;
    }
    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $qb->setFirstResult($this->offset);
    }
}
