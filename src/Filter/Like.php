<?php

namespace Happyr\DoctrineSpecification\Filter;

class Like extends Comparison
{
    const CONTAINS = 1;
    const ENDS_WITH = 2;
    const STARTS_WITH = 3;

    /**
     * @param string $field
     * @param mixed $value
     * @param int $format
     */
    public function __construct($field, $value, $format = self::CONTAINS)
    {
        parent::__construct($field, $value);
        $this->format = $format;
    }

    /**
     * @return int
     */
    public function getFormat()
    {
        return $this->format;
    }
}
