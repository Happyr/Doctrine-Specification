<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;

class Slice implements QueryModifier
{
    /**
     * @var int
     */
    private $sliceSize;

    /**
     * @var int
     */
    private $sliceNumber = 0;

    /**
     * @param int $sliceSize
     * @param int $sliceNumber
     */
    public function __construct($sliceSize, $sliceNumber = 0)
    {
        $this->sliceSize = $sliceSize;
        $this->sliceNumber = $sliceNumber;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $qb->setMaxResults($this->sliceSize);

        if ($this->sliceNumber > 0) {
            $qb->setFirstResult($this->sliceNumber * $this->sliceSize);
        }
    }
}
