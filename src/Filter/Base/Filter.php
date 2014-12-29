<?php

namespace Happyr\DoctrineSpecification\Filter\Base;

abstract class Filter implements FilterInterface
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
