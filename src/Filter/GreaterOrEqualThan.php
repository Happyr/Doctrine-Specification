<?php

namespace Happyr\DoctrineSpecification\Filter;

class GreaterOrEqualThan extends Comparison
{
    /**
     * @param string $field
     * @param string $value
     * @param string $dqlAlias
     */
    public function __construct($field, $value, $dqlAlias = null)
    {
        parent::__construct(self::GTE, $field, $value, $dqlAlias);
    }
}
