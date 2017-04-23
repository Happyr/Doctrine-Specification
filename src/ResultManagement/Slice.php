<?php

namespace Happyr\DoctrineSpecification\ResultManagement;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Specification;

class Slice implements Specification
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
