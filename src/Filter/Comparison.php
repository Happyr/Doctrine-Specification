<?php

namespace Happyr\DoctrineSpecification\Filter;

abstract class Comparison extends Filter implements ComparisonInterface, FilterInterface
{
    /**
     * @var mixed field
     */
    protected $value;

    /**
     * @param string $field
     * @param mixed $value
     */
    public function __construct($field, $value)
    {
        $this->field = $field;
        $this->$value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
