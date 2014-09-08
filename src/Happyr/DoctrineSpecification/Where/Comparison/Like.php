<?php

namespace Happyr\DoctrineSpecification\Where\Comparison;

class Like extends Comparison
{
    const CONTAINS = "%%%s%%";
    const ENDS_WITH = "%%%s";
    const STARTS_WITH = "%s%%";

    public function __construct($field, $value, $format = self::CONTAINS, $dqlAlias = null)
    {
        $pattern = $this->formatPattern($format, $value);
        parent::__construct(self::LIKE, $field, $pattern, $dqlAlias);
    }

    private function formatPattern($format, $value)
    {
        return sprintf($format, $value);
    }
}
