<?php

namespace Happyr\DoctrineSpecification\Logic;

use Happyr\DoctrineSpecification\InternalSpecificationInterface;

class AndX implements LogicX, InternalSpecificationInterface
{
    private $left;
    private $right;

    public function __construct(InternalSpecificationInterface $left, InternalSpecificationInterface $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    /**
     * @return mixed
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * @return mixed
     */
    public function getRight()
    {
        return $this->right;
    }
}
