<?php

namespace Happyr\DoctrineSpecification\Filter;

class IsNotNull implements Filter
{
    /**
     * @var string field
     */
    protected $field;

    /**
     * @param string      $field
     */
    public function __construct($field)
    {
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }
}
