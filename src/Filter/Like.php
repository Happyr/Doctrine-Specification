<?php

namespace Happyr\DoctrineSpecification\Filter;

class Like implements Comparison
{
    const CONTAINS = "%%%s%%";
    const ENDS_WITH = "%%%s";
    const STARTS_WITH = "%s%%";

    public function __construct($field, $value, $format = self::CONTAINS)
    {
        $this->value =
    }

    /**
     * @param string $format
     */
    private function formatValue($format, $value)
    {
        return sprintf($format, $value);
    }
}
