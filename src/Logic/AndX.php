<?php

namespace Happyr\DoctrineSpecification\Logic;


use Happyr\DoctrineSpecification\Filter\Base\FilterInterface;

class AndX implements LogicX
{
    private $left;
    private $right;

    public function __construct(FilterInterface $left, FilterInterface $right)
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

    /**
     * @return mixed Return field name to filter
     */
    public function getField()
    {
    }
}
