<?php

namespace Happyr\DoctrineSpecification\Filter\Base;

use Happyr\DoctrineSpecification\InternalSpecificationInterface;

abstract class Filter implements FilterInterface, InternalSpecificationInterface
{
    /**
     * @var string field
     */
    protected $field;

    /**
     * @param string $field
     */
    public function __construct($field)
    {
        $this->field = $field;
    }

    /**
     * @inheritdoc
     */
    public function getField()
    {
        return $this->field;
    }
}
